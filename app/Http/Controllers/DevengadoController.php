<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Devengado;
use App\Models\Almacen; // Asegúrate de tener este modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Necesario para verificar el tipo de usuario
use Illuminate\Support\Facades\DB; 

class DevengadoController extends Controller
{
    public function index(Request $request)
    {
        // Inicia la consulta con las relaciones para evitar N+1
        $query = Devengado::with('almacen', 'usuario');

        // --- Filtros de Búsqueda ---
        $almacenes = [];
        if (Auth::user()->tipo == 'admin') {
            $almacenes = Almacen::orderBy('nombre', 'asc')->get();
            if ($request->filled('almacen_id')) {
                $query->where('almacen_id', $request->almacen_id);
            }
        } else {
            $query->where('almacen_id', Auth::user()->almacen_id);
        }

        if ($request->filled('fecha_inicio')) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }
        if ($request->filled('oc')) {
            $query->where('oc', 'LIKE', '%' . $request->oc . '%');
        }
        if ($request->filled('siaf')) {
            $query->where('siaf', 'LIKE', '%' . $request->siaf . '%');
        }
        if ($request->filled('proveedor')) {
            $query->where('proveedor', 'LIKE', '%' . $request->proveedor . '%');
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        // --- Fin Filtros ---

        $estados = DB::table('devengados')->select('estado')->distinct()->orderBy('estado')->pluck('estado');

        $devengados = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query()); 

        return view('devengados', compact(
            'devengados',
            'almacenes', 
            'estados'    
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación (usando 'descripcion' y 'usuario_id')
        $data = $request->validate([
            'almacen_id'    => 'required|exists:almacens,id',
            'fecha'         => 'required|date',
            'oc'            => 'required|string|max:255',
            'siaf'          => 'nullable|string|max:255',
            'descripcion'   => 'required|string', // CORREGIDO
            'precio_total'  => 'required|numeric|min:0',
            'estado'        => 'required|string|in:pendiente,pagado,anulado',
            'observaciones' => 'nullable|string',
            'proveedor'     => 'nullable|string|max:255',
        ]);

        if (Auth::user()->tipo != 'admin') {
            $data['almacen_id'] = Auth::user()->almacen_id;
        }

        $data['usuario_id'] = Auth::id(); // CORREGIDO

        Devengado::create($data);

        return redirect()->route('devengados.index')->with('success', 'Devengado registrado exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Devengado $devengado)
    {
        
        // 1. Validación (usando 'descripcion')
        $data = $request->validate([
            'almacen_id'    => 'required|exists:almacens,id',
            'fecha'         => 'required|date',
            'oc'            => 'required|string|max:255',
            'siaf'          => 'nullable|string|max:255',
            'descripcion'   => 'required|string', // CORREGIDO
            'precio_total'  => 'required|numeric|min:0',
            'estado'        => 'required|string|in:pendiente,pagado,anulado',
            'observaciones' => 'nullable|string',
            'proveedor'     => 'nullable|string|max:255',
        ]);
        
        if (Auth::user()->tipo != 'admin') {
            $data['almacen_id'] = Auth::user()->almacen_id;
        }
        
        $devengado->update($data);

        return redirect()->route('devengados.index')->with('success', 'Devengado actualizado exitosamente.');
    }

    /**
     * Annul the specified resource. (Cambia estado a 'anulado')
     */
    public function anular(Devengado $devengado)
    {
        // 1. Restricción de permisos ELIMINADA (según tu solicitud)

        // 2. Comprobar si ya está anulado
        if ($devengado->estado == 'anulado') {
            return redirect()->route('devengados.index')->with('warning', 'Este registro ya se encontraba anulado.');
        }

        // 3. Anular el registro
        $devengado->update([
            'estado' => 'anulado'
        ]);

        return redirect()->route('devengados.index')->with('warning', 'El devengado ha sido anulado.');
    }
}