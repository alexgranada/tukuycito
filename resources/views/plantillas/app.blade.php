<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('titulo')</title>

    <!-- Meta -->

    <meta name="author" content="Alex Granada" />
    <link rel="shortcut icon" href="{{ asset('assets/images/icono.png') }}" />

    <!-- *************
   ************ CSS Files *************
   ************* -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}" />

    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- App header starts -->
        <div class="app-header d-flex align-items-center">

            <!-- Toggle buttons start -->
            <div class="d-flex">
                <button class="toggle-sidebar" id="toggle-sidebar">
                    <i class="bi bi-list lh-1"></i>
                </button>
                <button class="pin-sidebar" id="pin-sidebar">
                    <i class="bi bi-list lh-1"></i>
                </button>
            </div>
            <!-- Toggle buttons end -->

            <!-- App brand starts -->
            <div class="app-brand py-2 ms-3">
                <a href="{{ route('dashboard') }}" class="d-sm-block d-none">
                    <img src="{{ asset('assets/images/logo.png') }}" class="logo" alt="Tukuycito logo" />
                </a>
                <a href="{{ route('dashboard') }}" class="d-sm-none d-block">
                    <img src="{{ asset('assets/images/icono.png') }}" class="logo" alt="Tukuycito logo" />
                </a>
            </div>
            <!-- App brand ends -->

            <!-- App header actions start -->
            <div class="header-actions col">
                <div class="d-lg-flex d-none">
                    <div class="dropdown">
                        <a class="dropdown-toggle d-flex px-3 py-4 position-relative" href="#!" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-grid fs-4 lh-1 text-secondary"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow-lg">
                            <!-- Row start -->
                            <div class="d-flex gap-2 m-2">
                                <a href="https://siadeg.com.pe" class="g-col-4 p-2 border rounded-2">
                                    <img src="https://www.siadeg.com/img/Logo_SIADEG.jpg" class="img-3x"
                                        alt="Siadeg" />
                                </a>
                                <a href="https://tukuyobra.com/login" class="g-col-4 p-2 border rounded-2">
                                    <img src="https://tukuyobra.com/img/icono.png" class="img-3x" alt="tukuy obra" />
                                </a>
                            </div>
                            <!-- Row end -->
                        </div>
                    </div>

                    <div class="dropdown border-start">
                        <a class="dropdown-toggle d-flex px-3 py-4 position-relative" href="#!" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell fs-4 lh-1 text-secondary"></i>
                            <span class="count-label info"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow-lg">
                            <h5 class="fw-semibold px-3 py-2 text-primary">Notificaciones</h5>
                            <div class="dropdown-item">
                                <div class="d-flex py-2 border-bottom">
                                    <div class="icon-box md bg-success rounded-circle me-3">
                                        <span class="fw-bold text-white">AG</span>
                                    </div>
                                    <div class="m-0">
                                        <h6 class="mb-1 fw-semibold">Alex Granada Campana</h6>
                                        <p class="mb-1">
                                            Agregó un nuevo producto al inventario.
                                        </p>
                                        <p class="small m-0 text-secondary">Hoy, 07:30pm</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="dropdown ms-2">
                    <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center text-decoration-none"
                        href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/user2.png') }}" class="rounded-2 img-3x"
                            alt="Bootstrap Gallery" />
                        <span class="ms-2 text-truncate d-lg-block d-none">{{ Auth::user()->dni }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg">
                        <div class="d-flex flex-column align-items-center py-3 border-bottom">
                            <h5>{{ Auth::user()->apellidos }}</h5>
                            <h6>{{ Auth::user()->nombres }}</h6>
                            <small>{{ Auth::user()->tipo }}</small>
                        </div>
                        <div class="mx-3 mt-2 d-grid">
                            <a href="perfil" class="btn btn-success btn-sm">Perfil</a>
                        </div>

                        <!-- ***** INICIO: CAMBIO DE BOTÓN SALIR ***** -->
                        <div class="mx-3 mt-2 d-grid">
                            <!-- Se usa un formulario para enviar por POST, como lo requiere la ruta 'logout' -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    Salir
                                </button>
                            </form>
                        </div>
                        <!-- ***** FIN: CAMBIO DE BOTÓN SALIR ***** -->

                    </div>
                </div>
            </div>
            <!-- App header actions end -->

        </div>
        <!-- App header ends -->

        <!-- Main container start -->
        <div class="main-container">

            <!-- ***** INICIO: SECCIÓN SIDEBAR ACTUALIZADA ***** -->
            <!-- Sidebar wrapper start -->
            <nav id="sidebar" class="sidebar-wrapper">

                <!-- Sidebar profile starts -->
                <div class="shop-profile">
                    <p class="m-0">Almacén Asignado</p>
                    <p class="mb-1 fw-bold text-primary text-uppercase">{{ Auth::user()->almacen->nombre }}</p>
                </div>
                <!-- Sidebar profile ends -->

                <!-- Sidebar menu starts -->
                <div class="sidebarMenuScroll">
                    <ul class="sidebar-menu">

                        <!--
                            Nota: Se usa Route::is('...') para comprobar la ruta actual.
                            'active' en el li.treeview hace que el menú se expanda (si el JS está configurado para ello).
                            'active' o 'current-page' en el li hijo resalta el enlace específico.
                        -->

                        <li class="{{ Route::is('dashboard') ? 'active current-page' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <i class="bi bi-pie-chart"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>

                        <!-- Usamos 'devengados.*' para que coincida con .index, .create, .edit, etc. -->
                        <li class="treeview {{ Route::is('devengados.*') ? 'active' : '' }}">
                            <a href="#!">
                                <i class="bi bi-stickies"></i>
                                <span class="menu-text">Devengados</span>
                            </a>
                            <ul class="treeview-menu">
                                <!-- Clase 'active' para el <li> hijo -->
                                <li class="{{ Route::is('devengados.index') ? 'active' : '' }}">
                                    <a href="{{ route('devengados.index') }}">Lista</a>
                                </li>
                            </ul>
                        </li>

                        <li class="treeview {{ Route::is('paneles-fotograficos.*') ? 'active' : '' }}">
                            <a href="#!">
                                <i class="bi bi-ui-checks-grid"></i>
                                <span class="menu-text">Panel Fotográfico</span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ Route::is('paneles-fotograficos.index') ? 'active' : '' }}">
                                    <a href="{{ route('paneles-fotograficos.index') }}">Lista</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Aquí comprobamos dos grupos de rutas: prestamos.* O obras.* -->
                        <li class="treeview {{ Route::is('prestamos.*') || Route::is('obras.*') ? 'active' : '' }}">
                            <a href="#!">
                                <i class="bi bi-window-sidebar"></i>
                                <span class="menu-text">Préstamos</span>
                            </a>
                            <ul class="treeview-menu">
                                <!-- CORRECCIÓN: Cada enlace debe estar en su propio <li> -->
                                <li class="{{ Route::is('prestamos.index') ? 'active' : '' }}">
                                    <a href="{{ route('prestamos.index') }}">Lista</a>
                                </li>
                                <li class="{{ Route::is('obras.index') ? 'active' : '' }}">
                                    <a href="{{ route('obras.index') }}">Agregar Proyectos</a>
                                </li>
                            </ul>
                        </li>

                        <li class="{{ Route::is('productos.*') ? 'active current-page' : '' }}">
                            <a href="{{ route('productos.index') }}">
                                <i class="bi bi-border-all"></i>
                                <span class="menu-text">Productos</span>
                            </a>
                        </li>

                        <li class="treeview {{ Route::is('reportes.*') ? 'active' : '' }}">
                            <a href="#!">
                                <i class="bi bi-window-sidebar"></i>
                                <span class="menu-text">Reportes</span>
                            </a>
                            <ul class="treeview-menu">

                                <li class="{{-- {{ Route::is('reportes.devengados') ? 'active' : '' }} --}}">
                                    <a href="{{-- {{ route('reportes.devengados') }} --}}">Devengados</a>
                                </li>

                                <li class="{{-- {{ Route::is('reportes.prestamos') ? 'active' : '' }} --}}">
                                    <a href="#">Préstamos</a>
                                </li>

                                <li class="{{ Route::is('reportes.fotografico') ? 'active' : '' }}">
                                    <a href="{{ route('reportes.fotografico') }}">Panel Fotográfico</a>
                                </li>

                            </ul>
                        </li>

                        <hr>

                        <!-- Asumiendo que tendrás rutas como 'usuarios.index' y 'configuracion.index' -->
                        <!-- TODO: Cambia el href cuando tengas las rutas listas -->
                        <li class="{{ Route::is('usuarios.*') ? 'active current-page' : '' }}">
                            <a href="{{ route('usuarios.index') }}">
                                <i class="bi bi-calendar4"></i>
                                <span class="menu-text">Usuarios</span>
                            </a>
                        </li>
                        <li class="{{ Route::is('almacen.*') ? 'active current-page' : '' }}">
                            <a href="{{ route('almacen.index') }}">
                                <i class="bi bi-home"></i>
                                <span class="menu-text">Almacén</span>
                            </a>
                        </li>

                        <!-- TODO: Cambia el href cuando tengas las rutas listas -->
                        <li class="{{ Route::is('configuracion.*') ? 'active current-page' : '' }}">
                            <a href="#">
                                <i class="bi bi-gear"></i>
                                <span class="menu-text">Configuración</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar menu ends -->

            </nav>
            <!-- Sidebar wrapper end -->
            <!-- ***** FIN: SECCIÓN SIDEBAR ACTUALIZADA ***** -->


            <!-- App container starts -->
            <div class="app-container">
                <!-- App hero header starts -->
                <div class="app-hero-header d-flex align-items-center">
                    <!-- Breadcrumb start -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="bi bi-house lh-1 pe-3 me-3 border-end border-dark"></i>
                            <a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item text-secondary" aria-current="page">
                            @yield('nombre')
                        </li>
                    </ol>
                    <!-- Breadcrumb end -->

                    <!-- Sales stats start -->
                    <div class="ms-auto d-lg-flex d-none flex-row">
                        <div class="d-flex flex-row gap-2">
                            {{ \Carbon\Carbon::now()->locale('es')->translatedFormat('l, d F Y') }}

                        </div>
                    </div>
                    <!-- Sales stats end -->

                </div>
                <!-- App Hero header ends -->

                <!-- App body starts -->
                <div class="app-body">
                    @yield('contenido')


                </div>
                <!-- App body ends -->

                <!-- App footer start -->
                <div class="app-footer">
                    <span>© CENTRO DE INFORMÁTICA, PROYECTO:  MEJORAMIENTO Y AMPLIACION DE LOS SERVICIOS DE SALUD DEL
                        ESTABLECIMIENTO DE SALUD DE BELEMPAMPA - DISTRITO DE SANTIAGO - PROVINCIA DE CUSCO - REGION
                        CUSCO</span>
                </div>
                <!-- App footer end -->

            </div>
            <!-- App container ends -->

        </div>
        <!-- Main container end -->

    </div>
    <!-- Page wrapper end -->

    <!-- *************
   ************ JavaScript Files *************
   ************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>

    <!-- *************
   ************ Vendor Js Files *************
   ************* -->
    @yield('js')

    <!-- Custom JS files -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>
