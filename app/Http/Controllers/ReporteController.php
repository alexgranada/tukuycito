<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PanelFotografico;
use App\Models\Producto;

class ReporteController extends Controller
{
    /**
     * Muestra el reporte de Paneles Fotográficos con filtros avanzados.
     */
    public function panelFotografico(Request $request)
    {
        // Lógica de búsqueda avanzada
        $query = PanelFotografico::with('usuario', 'producto', 'fotos');

        // Filtro por Rango de Fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [$request->input('fecha_inicio'), $request->input('fecha_fin')]);
        }
        // Filtro por Producto
        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->input('producto_id'));
        }
        // Filtro por Guía
        if ($request->filled('n_guia')) {
            $query->where('n_guia', 'like', '%' . $request->input('n_guia') . '%');
        }
        // Filtro por Placa
        if ($request->filled('placa')) {
            $query->where('placa', 'like', '%' . $request->input('placa') . '%');
        }
        // Filtro por O/C
        if ($request->filled('oc')) {
            $query->where('oc', 'like', '%' . $request->input('oc') . '%');
        }

        $paneles = $query->orderBy('fecha', 'desc')->paginate(20)->withQueryString();
        
        // Productos para el filtro
        $productos = Producto::orderBy('nombre')->get();

        // Devolvemos la nueva vista de reporte
        return view('reportes.fotos', compact('paneles', 'productos'));
    }

    // Aquí podrías añadir 'public function prestamos(Request $request)' en el futuro
    // ...
}