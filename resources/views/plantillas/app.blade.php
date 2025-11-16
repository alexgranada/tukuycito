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
                        <div class="mx-3 mt-2 d-grid">
                            <a href="login.html" class="btn btn-primary btn-sm">Salir</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- App header actions end -->

        </div>
        <!-- App header ends -->

        <!-- Main container start -->
        <div class="main-container">

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
                        <li class="active current-page">
                            <a href="{{ route('dashboard') }}">
                                <i class="bi bi-pie-chart"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="treeview">
                            <a href="#!">
                                <i class="bi bi-stickies"></i>
                                <span class="menu-text">Devengados</span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('devengados.index') }}">Lista</a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#!">
                                <i class="bi bi-ui-checks-grid"></i>
                                <span class="menu-text">Panel Fotográfico</span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('paneles-fotograficos.index') }}">Lista</a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#!">
                                <i class="bi bi-window-sidebar"></i>
                                <span class="menu-text">Prestamos</span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ route('prestamos.index') }}">Lista</a>
                                    <a href="{{ route('obras.index') }}">Agregar Proyectos</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('productos.index') }}">
                                <i class="bi bi-border-all"></i>
                                <span class="menu-text">Productos</span>
                            </a>
                        </li>
                        <hr>
                        <li>
                            <a href="events.html">
                                <i class="bi bi-calendar4"></i>
                                <span class="menu-text">Usuarios</span>
                            </a>
                        </li>

                        <li>
                            <a href="settings.html">
                                <i class="bi bi-gear"></i>
                                <span class="menu-text">Configuración</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar menu ends -->

            </nav>
            <!-- Sidebar wrapper end -->

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
