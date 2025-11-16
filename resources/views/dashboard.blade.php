@extends('plantillas.app')
@section('titulo', 'Tukuycito - Dashboard')
@section('nombre', 'Dashboard')
@section('css')
@section('contenido')
    <!-- INICIO: KPIs Actualizados -->
    <div class="row gx-3">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-files fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Total Préstamos</h5>
                        <h3 class="m-0 text-primary">{{ $totalPrestamos }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-clock-history fs-1 text-danger lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Préstamos Pendientes</h5>
                        <h3 class="m-0 text-danger">{{ $prestamosPendientes }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-calendar-check fs-1 text-success lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Devengado (Mes)</h5>
                        <h3 class="m-0 text-success">S/ {{ number_format($devengadoMesActual, 2) }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-wallet2 fs-1 text-info lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Devengado (Total)</h5>
                        <h3 class="m-0 text-info">S/ {{ number_format($devengadoTotal, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN: KPIs Actualizados -->

    <!-- INICIO: Fila de Gráficos -->
    <div class="row gx-3">
        <div class="col-lg-8 col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Préstamos por Mes (Año Actual)</h5>
                </div>
                <div class="card-body">
                    <!-- Contenedor para el gráfico de barras -->
                    <div id="prestamosPorMesChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Estado de Préstamos</h5>
                </div>
                <div class="card-body">
                    <!-- Contenedor para el gráfico de dona -->
                    <div id="estadoPrestamosChart"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Fila de Gráficos -->


    <!-- INICIO: Nueva Fila de Gráfico (Almacenes) -->
    <div class="row gx-3">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Préstamos por Almacén</h5>
                </div>
                <div class="card-body">
                    <!-- Contenedor para el gráfico de barras horizontales -->
                    <div id="prestamosPorAlmacenChart"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Nueva Fila de Gráfico (Almacenes) -->

@endsection
@section('js')

    <!-- Overlay Scroll JS -->
    <script src="{{ asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>


    <!-- Apex Charts -->
    <script src="{{ asset('assets/vendor/apex/apexcharts.min.js') }}"></script>


    <!-- INICIO: Scripts para los nuevos gráficos -->
    <script>
        const prestamosMesData = @json($prestamosPorMes);
        const estadoPrestamosData = @json($estadoPrestamos);
        const prestamosAlmacenData = @json($prestamosPorAlmacen);
    </script>
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <!-- FIN: Scripts para los nuevos gráficos -->

@endsection
