<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Almacen;
use App\Models\Obra;
use App\Models\PrestamoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\User;

class PrestamoController extends Controller
{
    /**
     * Muestra la lista de préstamos con filtros y paginación.
     */
    public function index(Request $request)
    {
        // Iniciar la consulta con las relaciones necesarias para evitar N+1
        $query = Prestamo::with('user', 'obra', 'almacen', 'detalles');

        // Filtros de búsqueda
        if ($request->filled('numero_acta')) {
            $query->where('numero_acta', 'like', '%' . $request->numero_acta . '%');
        }

        if ($request->filled('obra_id')) {
            $query->where('obra_id', $request->obra_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_prestamo', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_prestamo', '<=', $request->fecha_fin);
        }

        // Lógica de Almacén: Admin ve todos, Usuario ve solo el suyo
        $user = Auth::user();
        $almacenes = collect(); // Inicializa como colección vacía

        if ($user->tipo == 'admin') {
            $almacenes = Almacen::orderBy('nombre', 'asc')->get();
            if ($request->filled('almacen_id')) {
                $query->where('almacen_id', $request->almacen_id);
            }
        } else {
            // Un usuario normal solo puede ver préstamos de su almacén
            $query->where('almacen_id', $user->almacen_id);
        }

        // Obtener datos para los filtros y modales
        $obras = Obra::orderBy('nombre', 'asc')->get();
        $estados = Prestamo::select('estado')->distinct()->pluck('estado');

        // Paginamos los resultados
        $prestamos = $query->orderBy('fecha_prestamo', 'desc')->paginate(15)->appends($request->all());

        return view('prestamos', compact('prestamos', 'almacenes', 'obras', 'estados'));
    }

    /**
     * Almacena un nuevo préstamo en la base de datos.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validación de datos
        $validator = Validator::make($request->all(), [
            'almacen_id' => 'required|exists:almacens,id',
            'obra_id' => 'required|exists:obras,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado' => 'required|string|max:20',
            'tipo_prestamo' => 'required|string|max:255',
            'numero_acta' => 'nullable|string|max:255|unique:prestamos,numero_acta',
            'observaciones' => 'nullable|string',
            'acta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB Max
            'form_type' => 'required|string',
            // --- Validación de Detalles ---
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|numeric|min:0.01',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ], [
            'detalles.required' => 'Debe agregar al menos un producto al préstamo.',
            'detalles.min' => 'Debe agregar al menos un producto al préstamo.',
        ]);

        // Asegurarse que el usuario no-admin solo guarde en su almacén
        if ($user->tipo != 'admin' && $request->almacen_id != $user->almacen_id) {
            return redirect()->route('prestamos.index')->with('error', 'No tiene permisos para registrar en ese almacén.');
        }

        if ($validator->fails()) {
            return redirect()->route('prestamos.index')
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();
        
        // --- CORRECCIÓN: Separar datos de maestro y detalles ---
        $masterData = collect($validatedData)->except('detalles')->all();
        $detallesData = $validatedData['detalles'];
        
        // --- INICIO DE TRANSACCIÓN ---
        DB::beginTransaction();
        try {
            // Manejo de subida de archivo 'acta'
            if ($request->hasFile('acta')) {
                $path = $request->file('acta')->store('actas_prestamos', 'public');
                $masterData['acta'] = $path; // <-- CORRECCIÓN: Añadir a masterData
            }

            // Asignar el usuario que registra
            $masterData['user_id'] = $user->id; // <-- CORRECCIÓN: Añadir a masterData

            // 1. Crear el Préstamo (Maestro)
            $prestamo = Prestamo::create($masterData); // <-- CORRECCIÓN: Usar masterData

            // 2. Crear los Detalles
            foreach ($detallesData as $detalle) { // <-- CORRECCIÓN: Usar detallesData
                $prestamo->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'user_id' => $user->id, // Usuario que registra el detalle
                ]);
            }

            // --- COMMIT DE TRANSACCIÓN ---
            DB::commit();

            return redirect()->route('prestamos.index')->with('success', 'Préstamo registrado exitosamente (con ' . count($detallesData) . ' productos).'); // <-- CORRECCIÓN: Usar detallesData

        } catch (\Exception $e) {
            // --- ROLLBACK EN CASO DE ERROR ---
            DB::rollBack();
            // Opcional: registrar el error $e->getMessage()
            return redirect()->route('prestamos.index')->with('error', 'Error al registrar el préstamo: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza un préstamo existente.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        $user = Auth::user();

        // Validación de datos
        $validator = Validator::make($request->all(), [
            'almacen_id' => 'required|exists:almacens,id',
            'obra_id' => 'required|exists:obras,id',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado' => 'required|string|max:20',
            'tipo_prestamo' => 'required|string|max:255',
            'numero_acta' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('prestamos')->ignore($prestamo->id),
            ],
            'observaciones' => 'nullable|string',
            'acta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB Max
            'form_type' => 'required|string',
            // --- Validación de Detalles ---
            'detalles' => 'required|array|min:1',
            'detalles.*.producto_id' => 'required|exists:productos,id',
            'detalles.*.cantidad' => 'required|numeric|min:0.01',
            'detalles.*.precio_unitario' => 'required|numeric|min:0',
        ], [
            'detalles.required' => 'Debe agregar al menos un producto al préstamo.',
            'detalles.min' => 'Debe agregar al menos un producto al préstamo.',
        ]);
        
        // Asegurarse que el usuario no-admin solo edite en su almacén
        if ($user->tipo != 'admin' && $request->almacen_id != $user->almacen_id) {
             return redirect()->route('prestamos.index')->with('error', 'No tiene permisos para editar en ese almacén.');
        }
        // Opcional: verificar si el préstamo original era de su almacén
        if ($user->tipo != 'admin' && $prestamo->almacen_id != $user->almacen_id) {
            return redirect()->route('prestamos.index')->with('error', 'No tiene permisos para editar este registro.');
        }

        if ($validator->fails()) {
            return redirect()->route('prestamos.index')
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();

        // --- CORRECCIÓN: Separar datos de maestro y detalles ---
        $masterData = collect($validatedData)->except('detalles')->all();
        $detallesData = $validatedData['detalles'];

        // --- INICIO DE TRANSACCIÓN ---
        DB::beginTransaction();
        try {
            // Manejo de actualización de archivo 'acta'
            if ($request->hasFile('acta')) {
                // Eliminar acta anterior si existe
                if ($prestamo->acta) {
                    Storage::disk('public')->delete($prestamo->acta);
                }
                // Guardar la nueva acta
                $path = $request->file('acta')->store('actas_prestamos', 'public');
                $masterData['acta'] = $path; // <-- CORRECCIÓN: Añadir a masterData
            }

            // 1. Actualizar el Préstamo (Maestro)
            $prestamo->update($masterData); // <-- CORRECCIÓN: Usar masterData

            // 2. Sincronizar Detalles (Estrategia: Borrar y Recrear)
            // Esto es mucho más simple y seguro que rastrear IDs.
            $prestamo->detalles()->delete(); // Borra todos los detalles antiguos

            foreach ($detallesData as $detalle) { // <-- CORRECCIÓN: Usar detallesData
                $prestamo->detalles()->create([
                    'producto_id' => $detalle['producto_id'],
                    'cantidad' => $detalle['cantidad'],
                    'precio_unitario' => $detalle['precio_unitario'],
                    'user_id' => $user->id,
                ]);
            }
        
            // --- COMMIT DE TRANSACCIÓN ---
            DB::commit();

            return redirect()->route('prestamos.index')->with('success', 'Préstamo actualizado exitosamente (con ' . count($detallesData) . ' productos).'); // <-- CORRECCIÓN: Usar detallesData
        
        } catch (\Exception $e) {
            // --- ROLLBACK EN CASO DE ERROR ---
            DB::rollBack();
            // Opcional: registrar el error $e->getMessage()
            return redirect()->route('prestamos.index')->with('error', 'Error al actualizar el préstamo: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un préstamo.
     * NOTA: La BD tiene ON DELETE CASCADE para prestamo_detalles.
     */
    public function destroy(Prestamo $prestamo)
    {
        $user = Auth::user();

        // Opcional: verificar si el préstamo era de su almacén
        if ($user->tipo != 'admin' && $prestamo->almacen_id != $user->almacen_id) {
            return redirect()->route('prestamos.index')->with('error', 'No tiene permisos para eliminar este registro.');
        }

        try {
            // Eliminar el archivo de acta si existe
            if ($prestamo->acta) {
                Storage::disk('public')->delete($prestamo->acta);
            }

            $prestamo->delete();

            return redirect()->route('prestamos.index')->with('success', 'Préstamo eliminado exitosamente (junto con sus detalles).');
        
        } catch (\Illuminate\Database\QueryException $e) {
            // Por si acaso, aunque los detalles se borran en cascada
            return redirect()->route('prestamos.index')->with('error', 'No se pudo eliminar el préstamo. Puede tener otros registros asociados.');
        }
    }

    /**
     * Obtiene los detalles de un préstamo para el modal de visualización.
     */
    public function getDetalles(Prestamo $prestamo)
    {
        // Verificar permisos (opcional pero recomendado)
        $user = Auth::user();
        if ($user->tipo != 'admin' && $prestamo->almacen_id != $user->almacen_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $detalles = $prestamo->detalles()->with('producto', 'user')->get();

        return response()->json($detalles);
    }
}