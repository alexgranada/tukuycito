<?php

namespace App\Http\Controllers;

use App\Models\Devengado;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. Consultas a la base de datos (Usando tu tabla `prestamos`) ---

        // KPIs de Préstamos
        $totalPrestamos = Prestamo::count();
        $prestamosPendientes = Prestamo::where('estado', 'prestado')->count();

        // --- 2. Datos de Devengados (Usando tus consultas reales) ---
        $devengadoMesActual = Devengado::whereMonth('fecha', Carbon::now()->month)->sum('precio_total');
        $devengadoTotal = Devengado::sum('precio_total');

        // --- 3. Datos para Gráficos ---

        // Gráfico de Barras: Préstamos por Mes (del año actual)
        $prestamosPorMesData = Prestamo::select(
            DB::raw('MONTH(fecha_prestamo) as mes'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('fecha_prestamo', Carbon::now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();
        
        // Formatear datos para el gráfico de barras
        $mesesLabels = [];
        $mesesValores = [];
        $mesesCompletos = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];

        $datosMeses = [];
        foreach ($prestamosPorMesData as $data) {
            $datosMeses[$data->mes] = $data->total;
        }

        foreach ($mesesCompletos as $num => $nombre) {
            $mesesLabels[] = $nombre;
            $mesesValores[] = $datosMeses[$num] ?? 0; // Si no hay datos para ese mes, pone 0
        }

        $prestamosPorMes = [
            'labels' => $mesesLabels,
            'valores' => $mesesValores,
        ];


        // Gráfico de Dona: Estado de los Préstamos
        $estadoPrestamosData = Prestamo::select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->get();

        $estadoPrestamos = [
            'labels' => $estadoPrestamosData->pluck('estado')->map(function ($value) {
                return ucfirst($value); // Pone la primera letra en mayúscula
            }),
            'valores' => $estadoPrestamosData->pluck('total'),
        ];


        // --- NUEVO GRÁFICO: Préstamos por Almacén ---
        // CAMBIO: Se usa DB::table() en lugar de Prestamo::join() para mayor robustez.
        // Esto evita problemas si el modelo Prestamo tiene scopes globales.
        $prestamosPorAlmacenData = DB::table('prestamos')
            ->join('almacens', 'prestamos.almacen_id', '=', 'almacens.id')
            ->select('almacens.nombre', DB::raw('COUNT(prestamos.id) as total'))
            ->groupBy('almacens.nombre')
            ->orderBy('total', 'DESC') // Ordenar por los que tienen más préstamos
            ->get();
        
        $prestamosPorAlmacen = [
            'labels' => $prestamosPorAlmacenData->pluck('nombre'),
            'valores' => $prestamosPorAlmacenData->pluck('total'),
        ];


        // --- 4. Enviar datos a la vista ---
        return view('dashboard', compact(
            'totalPrestamos',
            'prestamosPendientes',
            'devengadoMesActual',
            'devengadoTotal',
            'prestamosPorMes',
            'estadoPrestamos',
            'prestamosPorAlmacen' // <-- Añadido nuevo dato
        ));
    }
}