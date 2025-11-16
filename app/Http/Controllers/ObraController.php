<?php

namespace App\Http\Controllers;

use App\Models\Obra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ObraController extends Controller
{
    /**
     * Muestra la lista de obras con filtros y paginación.
     */
    public function index(Request $request)
    {
        $query = Obra::query();

        // Aplicar filtros de búsqueda
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('meta')) {
            $query->where('meta', 'like', '%' . $request->meta . '%');
        }

        if ($request->filled('responsable')) {
            $query->where('responsable', 'like', '%' . $request->responsable . '%');
        }

        // Paginamos los resultados y mantenemos los filtros en la URL
        $obras = $query->orderBy('nombre', 'asc')->paginate(15)->appends($request->all());

        return view('obras', compact('obras'));
    }

    /**
     * Almacena una nueva obra en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'meta' => 'required|string|max:20|unique:obras,meta',
            'responsable' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'ubicacion' => 'nullable|string|max:255',
            'form_type' => 'required|string', // Campo oculto para identificar el formulario
        ]);

        if ($validator->fails()) {
            return redirect()->route('obras.index')
                ->withErrors($validator)
                ->withInput(); // Vuelve con los errores y los datos antiguos
        }

        Obra::create($validator->validated());

        return redirect()->route('obras.index')->with('success', 'Obra registrada exitosamente.');
    }

    /**
     * Actualiza una obra existente.
     */
    public function update(Request $request, Obra $obra)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'meta' => [
                'required',
                'string',
                'max:20',
                Rule::unique('obras')->ignore($obra->id), // Ignora el ID actual al verificar unicidad
            ],
            'responsable' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'ubicacion' => 'nullable|string|max:255',
            'form_type' => 'required|string', // Campo oculto
        ]);

        if ($validator->fails()) {
            return redirect()->route('obras.index')
                ->withErrors($validator)
                ->withInput();
        }

        $obra->update($validator->validated());

        return redirect()->route('obras.index')->with('success', 'Obra actualizada exitosamente.');
    }

    /**
     * Elimina una obra.
     */
    public function destroy(Obra $obra)
    {
        try {
            // Lógica para verificar dependencias (ej. préstamos)
            // La base de datos (prestamos_obra_id_foreign) ya previene esto,
            // así que capturamos la excepción.
            $obra->delete();

            return redirect()->route('obras.index')->with('success', 'Obra eliminada exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de restricción de clave foránea
            if ($e->getCode() == '23000') {
                return redirect()->route('obras.index')->with('error', 'No se pudo eliminar la obra. Tiene préstamos u otros registros asociados.');
            }
            // Otro tipo de error
            return redirect()->route('obras.index')->with('error', 'No se pudo eliminar la obra. Ocurrió un error.');
        }
    }
}