<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - DNI y Clave</title>
    <!-- Carga de Bootstrap 5 CDN -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.html') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <style>
        /* Estilos personalizados para centrar y aplicar un fondo profesional */
        body {
            background: linear-gradient(135deg, #1f2937 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #ffffff;
            border-radius: 1rem;
            /* Esquinas redondeadas */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 2.5rem;
            max-width: 420px;
            width: 100%;
        }

        .btn-primary {
            background-color: #0d6efd;
            /* Color primario de Bootstrap */
            border-color: #0d6efd;
            border-radius: 0.75rem;
            /* Botón redondeado */
            font-weight: 700;
            transition: all 0.3s;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 0.65rem 1rem;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="text-center mb-5">
            <h1 class="h3 fw-bold text-gray-800">Acceso al Sistema</h1>
            <p class="text-muted">Ingresa tus credenciales para continuar.</p>
        </div>

        <!-- Formulario de Inicio de Sesión -->
        <form id="login-form" action="{{ route('login.post') }}" method="post">
          @csrf

            <!-- Campo DNI -->
            <div class="mb-4">
                <label for="dni" class="form-label fw-semibold" >DNI / Identificación</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    <input type="text" class="form-control" id="dni" name="dni"
                        placeholder="Ingresa tu número de DNI" required aria-describedby="dniHelp">
                </div>
                <div id="dniHelp" class="form-text">Usaremos tu DNI como identificador de usuario.</div>
            </div>

            <!-- Campo Clave -->
            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Clave (Contraseña)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Escribe tu clave secreta" required>
                </div>
            </div>

            <!-- Opciones de sesión y olvido de clave -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="rememberCheck">
                    <label class="form-check-label" for="rememberCheck">
                        Recordarme
                    </label>
                </div>
                <a href="#" class="text-decoration-none small text-primary">¿Olvidaste tu clave?</a>
            </div>

            <!-- Botón de Iniciar Sesión -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i> INICIAR SESIÓN
                </button>
            </div>

        </form>

        <!-- Mensaje (Simulación de notificaciones) -->
        <div id="message-box" class="mt-3 d-none p-3 small rounded-3 text-center"></div>

    </div>

    <!-- Carga de Bootstrap JS Bundle -->
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
