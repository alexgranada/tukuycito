<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AlmacenController extends Controller
{
    public function index(Request $request)
    {
        $query = Almacen::query();

        // Lógica de Búsqueda
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->input('nombre') . '%');
        }

        $almacenes = $query->orderBy('nombre')->paginate(10);

        return view('almacenes', compact('almacenes'));
    }

    /**
     * Almacena un nuevo almacén.
     */
    public function store(Request $request)
    {
        // 1. Validación
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:almacens,nombre',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.unique' => 'Ya existe un almacén con este nombre.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('almacen.index')
                ->withErrors($validator, 'create_almacen')
                ->withInput()
                ->with('open_modal', 'modalNuevoAlmacen');
        }

        // 2. Creación
        try {
            Almacen::create($request->all());
            return redirect()->route('almacen.index')->with('success', 'Almacén registrado con éxito.');

        } catch (\Exception $e) {
            Log::error("Error al guardar almacén: " . $e->getMessage());
            return redirect()->route('almacen.index')->with('error', 'Ocurrió un error al registrar el almacén.');
        }
    }

    /**
     * Actualiza un almacén existente.
     */
    public function update(Request $request, Almacen $almacen)
    {
        // 1. Validación
        $validator = Validator::make($request->all(), [
            'nombre' => [
                'required', 'string', 'max:100',
                Rule::unique('almacens')->ignore($almacen->id), // Ignorar al almacén actual
            ],
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.unique' => 'Ya existe un almacén con este nombre.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('almacen.index')
                ->withErrors($validator, 'edit_almacen_' . $almacen->id)
                ->withInput()
                ->with('open_modal', 'modalEditAlmacen-' . $almacen->id);
        }

        // 2. Actualización
        try {
            $almacen->update($request->all());
            return redirect()->route('almacen.index')->with('success', 'Almacén actualizado con éxito.');

        } catch (\Exception $e) {
            Log::error("Error al actualizar almacén: " . $e->getMessage());
            return redirect()->route('almacen.index')->with('error', 'Ocurrió un error al actualizar el almacén.');
        }
    }

    /**
     * Elimina un almacén.
     */
    public function destroy(Almacen $almacen)
    {
        try {
            // Intentar eliminar
            $almacen->delete();
            return redirect()->route('almacen.index')->with('success', 'Almacén eliminado con éxito.');
        
        } catch (\Illuminate\Database\QueryException $e) {
            // Capturar error de llave foránea (SQLSTATE[23000])
            if ($e->getCode() == '23000') {
                Log::warning("Intento de eliminar almacén en uso (ID: $almacen->id): " . $e->getMessage());
                return redirect()->route('almacen.index')->with('error', 'No se pudo eliminar. El almacén está siendo utilizado por usuarios, préstamos u otros registros.');
            }
            
            // Otro tipo de error
            Log::error("Error al eliminar almacén (ID: $almacen->id): " . $e->getMessage());
            return redirect()->route('almacen.index')->with('error', 'Ocurrió un error inesperado al eliminar.');
        }
    }
}
