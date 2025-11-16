<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tukuycito - Login</title>

    <meta name="author" content="Alex Granada" />

    <link rel="shortcut icon" href="{{ asset('assets/images/icono.png') }}" />

    <!-- Estilos (mantenemos los originales) -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}" />
</head>

<!-- 
  CAMBIO: 
  - Se añade un estilo inline para un fondo gradiente sutil.
  - Se quita 'bg-white' para que el gradiente sea visible.
-->
<body style="background: linear-gradient(120deg, #f8f9fa, #e9ecef);">
    
    <!-- Container start -->
    <div class="container">

        <!-- 
          CAMBIO: 
          - Se añade 'min-vh-100' y 'align-items-center' para centrar
            verticalmente el formulario en la página.
          - Se ajusta el 'col-' para una mejor responsividad del card.
        -->
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9">
                
                <form id="login-form" action="{{ route('login.post') }}" method="post">
                    @csrf
                    
                    <!-- 
                      CAMBIO: 
                      - Se reemplaza 'border rounded-2 p-4 mt-5' por un diseño
                        de tarjeta (card) con sombra y más redondeado.
                      - Se usa 'card', 'shadow-lg', 'border-0', 'rounded-4'.
                    -->
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4 p-sm-5">
                            <div class="login-form">
                                
                                <!-- CAMBIO: Se centra el logo -->
                                <a href="index.html" class="mb-4 d-flex justify-content-center">
                                    <img src="{{ asset('assets/images/logo.png') }}" class=""
                                        alt="logo tukuycito" width="250px" />
                                </a>
                                
                                <!-- CAMBIO: Tipografía actualizada y centrada -->
                                <h3 class="fw-light text-center mb-2">Bienvenido</h3>
                                <p class="text-muted text-center mb-4">Inicie sesión para continuar</p>

                                <div class="mb-3">
                                    <label class="form-label">Tu DNI</label>
                                    
                                    <!-- 
                                      CAMBIO: 
                                      - Se usa 'input-group' para añadir un icono
                                        al campo de DNI.
                                    -->
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-person-badge"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control @error('dni') is-invalid @enderror @error('not_registered') is-invalid @enderror"
                                            placeholder="Ingresa tu DNI" id="dni" name="dni"
                                            value="{{ old('dni') }}" required />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tu Clave</label>

                                    <!-- 
                                      CAMBIO: 
                                      - Se usa 'input-group' para añadir un icono
                                        al campo de clave.
                                    -->
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-shield-lock"></i>
                                        </span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Ingrese tu clave" id="password" name="password" required />
                                        <!-- INICIO: Botón para ver/ocultar clave -->
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                        </button>
                                        <!-- FIN: Botón para ver/ocultar clave -->
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" name="remember" value="true"
                                            id="rememberPassword" />
                                        <label class="form-check-label" for="rememberPassword">Recordar Clave</label>
                                    </div>
                                </div>

                                <div class="d-grid py-3 mt-3">
                                    <!-- CAMBIO: Se añade 'shadow-sm' al botón -->
                                    <button type="submit" class="btn btn-lg btn-primary shadow-sm">
                                        Ingresar
                                    </button>
                                </div>

                                <!-- CAMBIO: Se añade 'text-muted' -->
                                <div class="text-center py-3 text-muted">o accede con:</div>

                                <!-- 
                                  CAMBIO: 
                                  - Se usa 'd-grid' para que el botón ocupe 
                                    todo el ancho.
                                  - Se cambia type="submit" a type="button" 
                                    (asumiendo que esto iría a otra ruta)
                                -->
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-outline-danger d-flex align-items-center justify-content-center">
                                        <i class="bi bi-google me-2"></i>
                                        <span>Acceder con Google</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CDN de SweetAlert2 (JS) - Se mantiene igual -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script para mostrar alertas con SweetAlert2 - Se mantiene igual -->
    <script>
        // 1. Caso: Credenciales erróneas (DNI existe, pero clave incorrecta)
        @if ($errors->has('dni'))
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "{{ $errors->first('dni') }}",
                showConfirmButton: false,
                timer: 4000
            });
        @endif

        // 2. Caso: Usuario no registrado o acceso denegado (DNI no encontrado)
        @if ($errors->has('not_registered'))
            Swal.fire({
                position: "top-end",
                icon: "warning", // Usamos 'warning' para diferenciarlo del error de credenciales
                title: "{{ $errors->first('not_registered') }}",
                showConfirmButton: false,
                timer: 4000 // Más tiempo para que el usuario lea el mensaje largo
            });
        @endif
    </script>

    <!-- Script para ver/ocultar clave -->
    <script>
        // Espera a que el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function () {
            
            // Selecciona los elementos
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');

            // Verifica que los elementos existan antes de añadir el listener
            if (togglePasswordBtn && passwordInput && toggleIcon) {
                
                togglePasswordBtn.addEventListener('click', function () {
                    // Obtiene el tipo actual del input
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Cambia el icono
                    if (type === 'password') {
                        // Si es tipo password, el ojo debe estar tachado
                        toggleIcon.classList.remove('bi-eye');
                        toggleIcon.classList.add('bi-eye-slash');
                    } else {
                        // Si es tipo text, el ojo debe estar visible
                        toggleIcon.classList.remove('bi-eye-slash');
                        toggleIcon.classList.add('bi-eye');
                    }
                });
            }
        });
    </script>
</body>

</html>