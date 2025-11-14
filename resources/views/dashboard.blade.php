<!DOCTYPE html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>DASHBOARD - TUKUYCITO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon/favicon.png">
    <!-- Place favicon.ico in the root directory -->
    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
    <div id="preloader">
        <div id="loader"></div>
    </div>
    <header>
        <!-- header-area-start -->
        <div class="main-wraper">
            <div class="main-container fixed-top">
                <div class="header header-expand-sm expand-header">
                    <div class="header-left d-flex">
                        <div class="logo"><a href="{{ route('dashboard') }}"><img src="assets/img/logo/logo.png"
                                    alt="logo"></a></div>
                        <!-- canvas_open -->
                        <div class="canvas_open toggle-menu sidebar-collapse">
                            <button class="menu-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msFilter">
                                    <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="header-right d-none d-lg-block">
                        <ul class="navbar-item flex-row ml-auto">

                            <li class="nav-item dropdown user-brands">
                                <button class="nav-link apps" data-bs-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                        <path
                                            d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm5 2h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1zm1-6h4v4h-4V5zM3 20a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6zm2-5h4v4H5v-4zm8 5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6zm2-5h4v4h-4v-4z">
                                        </path>
                                    </svg>
                                </button>
                                <div class="dropdown-menu country-dt apps" data-popper-placement="none">
                                    <!-- single-apps -->
                                    <div class="dp-dropdown single-dropdown mb-10">
                                        <a href="#" class="dropdown-item">
                                            <img src="assets/img/app/3.png" alt="drive">
                                            <span>Google Drive</span>
                                        </a>
                                    </div>
                                    <!-- single-apps -->
                                    <div class="dp-dropdown single-dropdown mb-10">
                                        <a href="#" class="dropdown-item">
                                            <img src="assets/img/app/5.png" alt="github">
                                            <span>Github</span>
                                        </a>
                                    </div>

                                </div>
                            </li>

                            <!-- user-profile-start -->
                            <li class="nav-item dropdown user-profile">
                                <a href="#" class="user" data-bs-toggle="dropdown">
                                    <div class="user-profile-st">
                                        <img src="assets/img/author/1.png" alt="author">
                                        <div class="author-dt">
                                            <p>{{ Auth::user()->nombres }}</p>
                                            <span>{{ Auth::user()->apellidos }}</span>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu country-dt setting" data-popper-placement="none">
                                    <!-- single-item -->
                                    <div class="dp-dropdown">
                                        <a href="profile.html" class="dropdown-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24"
                                                style="fill: rgba(116, 116, 116, 1); transform: msfilter;">
                                                <path
                                                    d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z">
                                                </path>
                                            </svg>
                                            <span>Perfil</span>
                                        </a>
                                    </div>

                                    <div class="dp-dropdown">
                                        <a href="logout.html" class="dropdown-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24"
                                                style="fill: rgba(116, 116, 116, 1); transform: msfilter;">
                                                <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                                                <path
                                                    d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z">
                                                </path>
                                            </svg>
                                            <span>Salir</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="header-right-sm-dropdown d-block d-lg-none">
                        <button class="profile-dropdown">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <div class="header-right profile-active">
                            <ul class="navbar-item flex-row ml-auto">

                                <!-- brands-table-start -->
                                <li class="nav-item dropdown user-brands">
                                    <button class="nav-link apps" data-bs-toggle="dropdown">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24"
                                            style="fill: rgba(116, 116, 116, 1); transform: msfilter;">
                                            <path
                                                d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm5 2h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1zm1-6h4v4h-4V5zM3 20a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6zm2-5h4v4H5v-4zm8 5a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6zm2-5h4v4h-4v-4z">
                                            </path>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu country-dt apps" data-popper-placement="none">
                                        <!-- single-apps -->
                                        <div class="dp-dropdown single-dropdown mb-10">
                                            <a href="#" class="dropdown-item">
                                                <img src="assets/img/app/3.png" alt="drive">
                                                <span>Google Drive</span>
                                            </a>
                                        </div>
                                        <!-- single-apps -->
                                        <div class="dp-dropdown single-dropdown mb-10">
                                            <a href="#" class="dropdown-item">
                                                <img src="assets/img/app/5.png" alt="github">
                                                <span>Github</span>
                                            </a>
                                        </div>

                                    </div>
                                </li>

                                <!-- user-profile-start -->
                                <li class="nav-item dropdown user-profile">
                                    <a href="#" class="user" data-bs-toggle="dropdown">
                                        <div class="user-profile-st">
                                            <img src="assets/img/author/1.png" alt="author">
                                            <div class="author-dt">
                                                <p>{{ Auth::user()->nombres }}</p>
                                                <span>{{ Auth::user()->apellidos }}</span>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu country-dt setting" data-popper-placement="none">
                                        <!-- single-item -->
                                        <div class="dp-dropdown">
                                            <a href="profile.html" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24"
                                                    style="fill: rgba(116, 116, 116, 1); transform: msfilter;">
                                                    <path
                                                        d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z">
                                                    </path>
                                                </svg>
                                                <span>Perfil</span>
                                            </a>
                                        </div>

                                        <div class="dp-dropdown">
                                            <a href="logout.html" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24"
                                                    style="fill: rgba(116, 116, 116, 1);transform: msfilter;">
                                                    <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                                                    <path
                                                        d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z">
                                                    </path>
                                                </svg>
                                                <span>Salir</span>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- header-area-end -->
    </header>
    <main>
        <!-- sidebar-menu-area-start -->
        <div class="offcanvas_menu_wrapper left-menu">
            <div id="menu" class="text-left">
                <ul class="offcanvas_main_menu single-sidebar">
                    <li class="sub-title mt-15 mb-15">
                        <span>Principal</span>
                    </li>

                    <!-- single-menu-list -->
                    <li class="menu-item-has-children">
                        <a href="chat.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path
                                    d="M12 2C6.486 2 2 5.589 2 10c0 2.908 1.898 5.516 5 6.934V22l5.34-4.005C17.697 17.852 22 14.32 22 10c0-4.411-4.486-8-10-8zm0 14h-.333L9 18v-2.417l-.641-.247C5.67 14.301 4 12.256 4 10c0-3.309 3.589-6 8-6s8 2.691 8 6-3.589 6-8 6z">
                                </path>
                            </svg>
                            Dashboard</a>
                    </li>

                    <li class="sub-title mt-15 mb-15">
                        <span>Panel Fotográfico</span>
                    </li>
                    
                    
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children notback">
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path
                                    d="M12 2A10.13 10.13 0 0 0 2 12a10 10 0 0 0 4 7.92V20h.1a9.7 9.7 0 0 0 11.8 0h.1v-.08A10 10 0 0 0 22 12 10.13 10.13 0 0 0 12 2zM8.07 18.93A3 3 0 0 1 11 16.57h2a3 3 0 0 1 2.93 2.36 7.75 7.75 0 0 1-7.86 0zm9.54-1.29A5 5 0 0 0 13 14.57h-2a5 5 0 0 0-4.61 3.07A8 8 0 0 1 4 12a8.1 8.1 0 0 1 8-8 8.1 8.1 0 0 1 8 8 8 8 0 0 1-2.39 5.64z">
                                </path>
                                <path
                                    d="M12 6a3.91 3.91 0 0 0-4 4 3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4 3.91 3.91 0 0 0-4-4zm0 6a1.91 1.91 0 0 1-2-2 1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2 1.91 1.91 0 0 1-2 2z">
                                </path>
                            </svg>Panel Fotográfico</a>
                        <ul class="sub-menu sidebar">
                            <li><a href="team-member.html">Lista</a></li>
                            <li><a href="user-list.html">Reporte</a></li>
                        </ul>
                    </li>
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children notback">
                        <a href="profile.html"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path
                                    d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z">
                                </path>
                            </svg>
                            profile</a>
                    </li>
                    <!-- single-menu-list -->
                    <li class="sub-title mt-15 mb-15">
                        <span>modules</span>
                    </li>
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children notback">
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path
                                    d="M5 18v3.766l1.515-.909L11.277 18H16c1.103 0 2-.897 2-2V8c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h1zM4 8h12v8h-5.277L7 18.234V16H4V8z">
                                </path>
                                <path
                                    d="M20 2H8c-1.103 0-2 .897-2 2h12c1.103 0 2 .897 2 2v8c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2z">
                                </path>
                            </svg>
                            form</a>
                        <ul class="sub-menu sidebar">
                            <li><a href="form-layout.html">form layout</a></li>
                            <li><a href="form-elements.html">form elements</a></li>
                            <li><a href="form-components.html">form components</a></li>
                            <li><a href="form-validation.html">form validation</a></li>
                        </ul>
                    </li>
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children notback">
                        <a href="table.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path
                                    d="M4 21h15.893c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zm0-2v-5h4v5H4zM14 7v5h-4V7h4zM8 7v5H4V7h4zm2 12v-5h4v5h-4zm6 0v-5h3.894v5H16zm3.893-7H16V7h3.893v5z">
                                </path>
                            </svg>table</a>
                    </li>
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children notback">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path
                                    d="M20 17V7c0-2.168-3.663-4-8-4S4 4.832 4 7v10c0 2.168 3.663 4 8 4s8-1.832 8-4zM12 5c3.691 0 5.931 1.507 6 1.994C17.931 7.493 15.691 9 12 9S6.069 7.493 6 7.006C6.069 6.507 8.309 5 12 5zM6 9.607C7.479 10.454 9.637 11 12 11s4.521-.546 6-1.393v2.387c-.069.499-2.309 2.006-6 2.006s-5.931-1.507-6-2V9.607zM6 17v-2.393C7.479 15.454 9.637 16 12 16s4.521-.546 6-1.393v2.387c-.069.499-2.309 2.006-6 2.006s-5.931-1.507-6-2z">
                                </path>
                            </svg>
                            extended ui
                        </a>
                        <ul class="sub-menu sidebar">
                            <li><a href="range-slider.html">range slider</a></li>
                            <li><a href="rating.html">rating</a></li>
                        </ul>
                    </li>
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children notback">
                        <a href="chart.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path
                                    d="M20 7h-4V4c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H4c-1.103 0-2 .897-2 2v9a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V9c0-1.103-.897-2-2-2zM4 11h4v8H4v-8zm6-1V4h4v15h-4v-9zm10 9h-4V9h4v10z">
                                </path>
                            </svg>charts</a>
                    </li>
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children">
                        <a href="google-map.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path
                                    d="M12 14c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z">
                                </path>
                                <path
                                    d="M11.42 21.814a.998.998 0 0 0 1.16 0C12.884 21.599 20.029 16.44 20 10c0-4.411-3.589-8-8-8S4 5.589 4 9.995c-.029 6.445 7.116 11.604 7.42 11.819zM12 4c3.309 0 6 2.691 6 6.005.021 4.438-4.388 8.423-6 9.73-1.611-1.308-6.021-5.294-6-9.735 0-3.309 2.691-6 6-6z">
                                </path>
                            </svg>
                            Google map
                        </a>
                    </li>
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children">
                        <a href="calender.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path d="M7 11h2v2H7zm0 4h2v2H7zm4-4h2v2h-2zm0 4h2v2h-2zm4-4h2v2h-2zm0 4h2v2h-2z">
                                </path>
                                <path
                                    d="M5 22h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zM19 8l.001 12H5V8h14z">
                                </path>
                            </svg>
                            calender
                        </a>
                    </li>
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children notback">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path
                                    d="M12 16c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4zm0-6c1.084 0 2 .916 2 2s-.916 2-2 2-2-.916-2-2 .916-2 2-2z">
                                </path>
                                <path
                                    d="m2.845 16.136 1 1.73c.531.917 1.809 1.261 2.73.73l.529-.306A8.1 8.1 0 0 0 9 19.402V20c0 1.103.897 2 2 2h2c1.103 0 2-.897 2-2v-.598a8.132 8.132 0 0 0 1.896-1.111l.529.306c.923.53 2.198.188 2.731-.731l.999-1.729a2.001 2.001 0 0 0-.731-2.732l-.505-.292a7.718 7.718 0 0 0 0-2.224l.505-.292a2.002 2.002 0 0 0 .731-2.732l-.999-1.729c-.531-.92-1.808-1.265-2.731-.732l-.529.306A8.1 8.1 0 0 0 15 4.598V4c0-1.103-.897-2-2-2h-2c-1.103 0-2 .897-2 2v.598a8.132 8.132 0 0 0-1.896 1.111l-.529-.306c-.924-.531-2.2-.187-2.731.732l-.999 1.729a2.001 2.001 0 0 0 .731 2.732l.505.292a7.683 7.683 0 0 0 0 2.223l-.505.292a2.003 2.003 0 0 0-.731 2.733zm3.326-2.758A5.703 5.703 0 0 1 6 12c0-.462.058-.926.17-1.378a.999.999 0 0 0-.47-1.108l-1.123-.65.998-1.729 1.145.662a.997.997 0 0 0 1.188-.142 6.071 6.071 0 0 1 2.384-1.399A1 1 0 0 0 11 5.3V4h2v1.3a1 1 0 0 0 .708.956 6.083 6.083 0 0 1 2.384 1.399.999.999 0 0 0 1.188.142l1.144-.661 1 1.729-1.124.649a1 1 0 0 0-.47 1.108c.112.452.17.916.17 1.378 0 .461-.058.925-.171 1.378a1 1 0 0 0 .471 1.108l1.123.649-.998 1.729-1.145-.661a.996.996 0 0 0-1.188.142 6.071 6.071 0 0 1-2.384 1.399A1 1 0 0 0 13 18.7l.002 1.3H11v-1.3a1 1 0 0 0-.708-.956 6.083 6.083 0 0 1-2.384-1.399.992.992 0 0 0-1.188-.141l-1.144.662-1-1.729 1.124-.651a1 1 0 0 0 .471-1.108z">
                                </path>
                            </svg>
                            setting
                        </a>
                        <ul class="sub-menu sidebar">
                            <li><a href="account-setting.html">account setting</a></li>
                            <li><a href="change-password.html">change password</a></li>
                            <li><a href="privacy-policy.html">privacy policy</a></li>
                        </ul>
                    </li>
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children">
                        <a href="logout.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msfilter">
                                <path d="M16 13v-2H7V8l-5 4 5 4v-3z"></path>
                                <path
                                    d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z">
                                </path>
                            </svg>
                            logout
                        </a>
                    </li>
                    <!-- single-menu-list -->
                    <li class="menu-item-has-children notback menu-lavel-one">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" style="fill: rgba(116, 116, 116, 1); transform: msFilter">
                                <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path>
                            </svg>
                            Menu Lavels
                        </a>
                        <ul class="sub-menu sidebar">
                            <li><a href="#">Lavel One</a></li>
                            <li><a href="#">Lavel One</a></li>
                            <li class="menu-item-has-children notback menu-lavel-two">
                                <a href="#">Menu Two</a>
                                <ul class="sub-menu sidebar">
                                    <li><a href="#">Lavel Two</a></li>
                                    <li><a href="#">Lavel Two</a></li>
                                    <li class="menu-item-has-children notback  menu-lavel-three">
                                        <a href="#">Menu Three</a>
                                        <ul class="sub-menu sidebar">
                                            <li><a href="#">Lavel Three</a></li>
                                            <li><a href="#">Lavel Three</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- single-menu-list -->
                </ul>
            </div>
        </div>
        <!--sidebar-menu-end-->
        <!-- main-content-start -->
        <div class="content-wraper">
            <div class="container-fluid">
                <div class="row mb-30">
                    <div class="col-lg-12">
                        <!-- deshbord-title -->
                        <div class="deshbord-title">
                            <h2>Project Management</h2>
                            <ul>
                                <li><a href="{{ route('dashboard') }}">Dashboard</a><i
                                        class="fa-solid fa-angle-right"></i></li>
                                <li>Project Management</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- customer-area-start -->
                <div class="sales-widget">
                    <div class="row">
                        <!-- single-card  -->
                        <div class="col-lg-4 col-md-6 mb-20">
                            <div class="project-card-wrapper">
                                <div class="card-body-inner">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="project-card-title mb-10">Revenue</span>
                                            <h4>$4805</h4>
                                            <span class="project-card-para"><i class="fa-solid fa-caret-down"></i>$34
                                                Since last week</span>
                                        </div>
                                        <div class="widgets-icons"><i class="fa-solid fa-folder-open"></i></div>
                                    </div>
                                    <div id="chart1"></div>
                                </div>
                            </div>
                        </div>
                        <!-- single-card  -->
                        <div class="col-lg-4 col-md-6 mb-20">
                            <div class="project-card-wrapper">
                                <div class="card-body-inner">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="project-card-title mb-10">Active Visitor</span>
                                            <h4>8.4K</h4>
                                            <span class="project-card-para project-card-para-2"><i
                                                    class="fa-solid fa-caret-down"></i>14% Since last week</span>
                                        </div>
                                        <div class="widgets-icons  widgets-icons-2"><i class="fa-solid fa-users"></i>
                                        </div>
                                    </div>
                                    <div id="chart2"></div>
                                </div>
                            </div>
                        </div>
                        <!-- single-card  -->
                        <div class="col-lg-4 col-md-6 mb-20">
                            <div class="project-card-wrapper">
                                <div class="card-body-inner">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="project-card-title mb-10">Total Visitor</span>
                                            <h4>56k</h4>
                                            <span class="project-card-para project-card-para-3"><i
                                                    class="fa-solid fa-caret-down"></i>12.4% Since last week</span>
                                        </div>
                                        <div class="widgets-icons widgets-icons-3"><i
                                                class="fa-solid fa-user-astronaut"></i></div>
                                    </div>
                                    <div id="chart3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- project-progres-start -->
                <div class="project-progres-area">
                    <div class="row">
                        <div class="col-lg-5 mb-20 h-100">
                            <div class="sales-analytics-area pb-20 border-default h-100">
                                <div class="analycic-top">
                                    <div class="analycic-title">
                                        <h4>Project Progress</h4>
                                    </div>
                                    <div class="analycic-date">
                                        <select class="year-select" aria-label="default select example">
                                            <option value="1">year 2024</option>
                                            <option value="2">year 2025</option>
                                            <option value="3">year 2026</option>
                                            <option value="4">year 2027</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div id="chart4"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 mb-20">
                            <div class="sales-analytics-area border-default">
                                <div class="analycic-top">
                                    <div class="analycic-title">
                                        <h4>Project Roadmap</h4>
                                    </div>
                                    <div class="analycic-date">
                                        <select class="year-select" aria-label="default select example">
                                            <option selected value="1">this week</option>
                                            <option value="2">last week</option>
                                            <option value="3">this month</option>
                                            <option value="4">last month</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div id="chart5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- project-progres-end -->
                <!-- all-project-area-start -->
                <div class="all-project-area">
                    <div class="row">
                        <div class="col-lg-12 mb-20">
                            <div class="panel border-default min-selles">
                                <div class="top-sellers">
                                    <div class="top-sellers-title analycic-top pb-10">
                                        <div class="analycic-title">
                                            <h4>All Project</h4>
                                        </div>
                                        <div class="analycic-date">
                                            <select class="year-select" aria-label="default select example">
                                                <option selected value="1">this week</option>
                                                <option value="2">last week</option>
                                                <option value="3">this month</option>
                                                <option value="4">last month</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="recent-order-table min-height-scroll table-responsive table-responsive-md table-responsive-lg table-responsive-xl">
                                    <table class="table table-dashed table-responsive-lg recent-order-table">
                                        <thead>
                                            <tr class="title-table">
                                                <th>Project Name</th>
                                                <th>Members</th>
                                                <th>Start date</th>
                                                <th>Budget</th>
                                                <th>Deadline</th>
                                                <th>Progress</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="#">Web Development</a></td>
                                                <td>
                                                    <ul class="member">
                                                        <li><a href="#"><img src="assets/img/sellers/1.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/2.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/3.jpg"
                                                                    alt="sellers"></a></li>
                                                    </ul>
                                                </td>
                                                <td>01 jan, 2024</td>
                                                <td>$12,000</td>
                                                <td>03 jan, 2024</td>
                                                <td>
                                                    <div class="progress radius-10" style="height:5px">
                                                        <div class="progress-bar bg-primary w-75" role="progressbar">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-success">active</span></td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">Product Development</a></td>
                                                <td>
                                                    <ul class="member">
                                                        <li><a href="#"><img src="assets/img/sellers/4.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/5.jpg"
                                                                    alt="sellers"></a></li>
                                                    </ul>
                                                </td>
                                                <td>05 jan, 2024</td>
                                                <td>$7,000</td>
                                                <td>06 jan, 2024</td>
                                                <td>
                                                    <div class="progress radius-10" style="height:5px">
                                                        <div class="progress-bar bg-danger w-50" role="progressbar">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">complited</span>
                                                </td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">Nursery Management System</a></td>
                                                <td>
                                                    <ul class="member">
                                                        <li><a href="#"><img src="assets/img/sellers/7.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/8.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/9.jpg"
                                                                    alt="sellers"></a></li>
                                                    </ul>
                                                </td>
                                                <td>07 jan, 2024</td>
                                                <td>$140,00</td>
                                                <td>08 jan, 2024</td>
                                                <td>
                                                    <div class="progress radius-10" style="height:5px">
                                                        <div class="progress-bar bg-primary w-75" role="progressbar">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-info">Pending</span></td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">Hotel Management System</a></td>
                                                <td>
                                                    <ul class="member">
                                                        <li><a href="#"><img src="assets/img/sellers/1.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/2.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/3.jpg"
                                                                    alt="sellers"></a></li>
                                                    </ul>
                                                </td>
                                                <td>09 jan, 2024</td>
                                                <td>$11,000</td>
                                                <td>10 jan, 2024</td>
                                                <td>
                                                    <div class="progress radius-10" style="height:5px">
                                                        <div class="progress-bar bg-success w-100" role="progressbar">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">active</span>
                                                </td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">Engineering Lite Touch</a></td>
                                                <td>
                                                    <ul class="member">
                                                        <li><a href="#"><img src="assets/img/sellers/8.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/4.jpg"
                                                                    alt="sellers"></a></li>
                                                    </ul>
                                                </td>
                                                <td>11 jan, 2024</td>
                                                <td>$12,000</td>
                                                <td>12 jan, 2024</td>
                                                <td>
                                                    <div class="progress radius-10" style="height:5px">
                                                        <div class="progress-bar bg-primary w-50" role="progressbar">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-danger">Canceled</span></td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">Python Upgrade</a> </td>
                                                <td>
                                                    <ul class="member">
                                                        <li><a href="#"><img src="assets/img/sellers/1.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/2.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/3.jpg"
                                                                    alt="sellers"></a></li>
                                                    </ul>
                                                </td>
                                                <td>13 jan, 2024</td>
                                                <td>$22,000</td>
                                                <td>14 jan, 2024</td>
                                                <td>
                                                    <div class="progress radius-10" style="height:5px">
                                                        <div class="progress-bar bg-danger w-50" role="progressbar">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-info">Pending</span></td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="#">Construction Project Monitoring</a></td>
                                                <td>
                                                    <ul class="member">
                                                        <li><a href="#"><img src="assets/img/sellers/10.jpg"
                                                                    alt="sellers"></a></li>
                                                        <li><a href="#"><img src="assets/img/sellers/7.jpg"
                                                                    alt="sellers"></a></li>
                                                    </ul>
                                                </td>
                                                <td>15 jan, 2024</td>
                                                <td>$12,02</td>
                                                <td>16 jan, 2024</td>
                                                <td>
                                                    <div class="progress radius-10" style="height:5px">
                                                        <div class="progress-bar bg-success w-100" role="progressbar">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-info">Pending</span></td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- all-project-area-end -->
                <!-- to-do-list-area-start -->
                <div class="to-do-list-area">
                    <div class="row">
                        <div class="col-lg-7  mb-20">
                            <div class="panel border-default min-selles">
                                <div class="top-sellers">
                                    <div class="top-sellers-title analycic-top pb-10">
                                        <div class="analycic-title">
                                            <h4>To Do List</h4>
                                            <span>Task assigned to me 300</span>
                                        </div>
                                        <div class="search-form todo-search-form">
                                            <form action="#">
                                                <div class="input">
                                                    <input type="text" name="search" placeholder="Search">
                                                    <div class="search-icon">
                                                        <button type="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24"
                                                                style="fill: rgba(116, 116, 116, 1); transform: msFilter;">
                                                                <path
                                                                    d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="recent-order-table min-height-scroll table-responsive table-responsive-md table-responsive-lg table-responsive-xl">
                                    <table
                                        class="table table-dashed table-responsive-lg recent-order-table recent-order-table-2">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="form-checkbox d-flex align-items-center">
                                                        <input id="checkbox1" type="checkbox">
                                                        <label class="form-checkbox" for="checkbox1">Hotel Management
                                                            System</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Assigned To</span>
                                                        <span class="d-block m-0">Amanda Nanes</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Status</span>
                                                        <span class="d-block m-0">On Process</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Deadline</span>
                                                        <span class="d-block m-0">26 mar, 2024</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-checkbox d-flex align-items-center">
                                                        <input id="checkbox2" type="checkbox">
                                                        <label class="form-checkbox" for="checkbox2">Product
                                                            Development</label>
                                                    </div>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Assigned To</span>
                                                        <span class="d-block m-0">Iftikar Ammed</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Status</span>
                                                        <span class="d-block m-0">Urgent</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Deadline</span>
                                                        <span class="d-block m-0">13 nov, 2024</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-checkbox d-flex align-items-center">
                                                        <input id="checkbox3" type="checkbox">
                                                        <label class="form-checkbox" for="checkbox3">Nursery
                                                            Management System</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Assigned To</span>
                                                        <span class="d-block m-0">Sadab Khan</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Status</span>
                                                        <span class="d-block m-0">active</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Deadline</span>
                                                        <span class="d-block m-0">20 may, 2024</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-checkbox d-flex align-items-center">
                                                        <input id="checkbox4" type="checkbox">
                                                        <label class="form-checkbox" for="checkbox4">Hotel Management
                                                            System</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Assigned To</span>
                                                        <span class="d-block m-0">Hoyder Ali</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Status</span>
                                                        <span class="d-block m-0">active</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Deadline</span>
                                                        <span class="d-block m-0">21 jan, 2024</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-checkbox d-flex align-items-center">
                                                        <input id="checkbox5" type="checkbox">
                                                        <label class="form-checkbox" for="checkbox5">Engineering Lite
                                                            Touch</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Assigned To</span>
                                                        <span class="d-block m-0">Alaysa Haly</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Status</span>
                                                        <span class="d-block m-0">on progress</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Deadline</span>
                                                        <span class="d-block m-0">14 mar, 2024</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-checkbox d-flex align-items-center">
                                                        <input id="checkbox6" type="checkbox">
                                                        <label class="form-checkbox" for="checkbox6">Python
                                                            Upgrade</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Assigned To</span>
                                                        <span class="d-block m-0">Natalush Khan</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Status</span>
                                                        <span class="d-block m-0">on progress</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Deadline</span>
                                                        <span class="d-block m-0">14 jan, 2024</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-checkbox d-flex align-items-center">
                                                        <input id="checkbox7" type="checkbox">
                                                        <label class="form-checkbox" for="checkbox7">Construction
                                                            Project Monitoring</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Assigned To</span>
                                                        <span class="d-block m-0">Raihan Nanes</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Status</span>
                                                        <span class="d-block m-0">on progress</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-assigned">
                                                        <span class="assigned d-block m-0">Deadline</span>
                                                        <span class="d-block m-0">16 jan, 2024</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-box">
                                                        <button><i class="fa-solid fa-eye"></i></button>
                                                        <button><i class="fa-solid fa-pen"></i></button>
                                                        <button><i class="fa-solid fa-trash text-danger"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-modal">
                                    <button type="button" class="btn btn-primary mt-10" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" data-bs-whatever="@mdo">+ Add New Task</button>

                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New To Do
                                                        List</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="#">
                                                        <div class="project-form-single mb-3">
                                                            <label for="Project-name" class="col-form-label">Project
                                                                Name</label>
                                                            <input type="text" class="form-control"
                                                                id="Project-name">
                                                        </div>
                                                        <div class="project-form-single mb-3">
                                                            <label for="assigned-to" class="col-form-label">Assigned
                                                                To</label>
                                                            <input type="text" class="form-control"
                                                                id="assigned-to">
                                                        </div>
                                                        <div class="project-form-single mb-3">
                                                            <label for="status"
                                                                class="col-form-label">Status</label>
                                                            <input type="text" class="form-control"
                                                                id="status">
                                                        </div>
                                                        <div class="project-form-single mb-3">
                                                            <label for="deadline"
                                                                class="col-form-label">Deadline</label>
                                                            <input type="date" class="form-control"
                                                                id="deadline">
                                                        </div>
                                                        <button type="button" class="btn btn-primary">Save</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 mb-20 h-100">
                            <div class="project-distribution h-100">
                                <div class="sales-analytics-area pb-20 border-default h-100">
                                    <div class="analycic-top">
                                        <div class="analycic-title">
                                            <h4>Project Distribution</h4>
                                        </div>
                                        <div class="analycic-date">
                                            <select class="year-select" aria-label="default select example">
                                                <option selected value="1">this weak</option>
                                                <option value="2">last week</option>
                                                <option value="3">this week</option>
                                                <option value="4">last week</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div id="chart7"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- to-do-list-area-end -->
                <!-- project-budget-area-start -->
                <div class="project-budget-area">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="project-budget">
                                <div class="sales-analytics-area border-default h-100">
                                    <div class="analycic-top">
                                        <div class="analycic-title">
                                            <h4>Project Budget</h4>
                                        </div>
                                        <div class="analycic-date">
                                            <select class="year-select" aria-label="default select example">
                                                <option selected value="1">this Month</option>
                                                <option value="2">last week</option>
                                                <option value="3">this month</option>
                                                <option value="4">last month</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div id="chart6"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- project-budget-area-end -->
                <!-- footer start -->
                <div class="footer mt-20">
                    <p>Copyright© All Rights Reserved By <a href="#" class="t-name">Syndrox</a></p>
                </div>
                <!-- footer end -->
            </div>
        </div>
        <!-- main-content-end -->
    </main>

    <!-- JS here -->
    <script src="{{ asset('assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/apex-charts.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/deshbord.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
