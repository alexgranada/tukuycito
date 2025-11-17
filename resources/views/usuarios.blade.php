@extends('plantillas.app')
@section('titulo', 'Tukuycito - Usuarios')
@section('nombre', 'Gestión de Usuarios')
@section('css')
    {{-- CSS Específico si es necesario --}}
@endsection
@section('contenido')

    <!-- INICIO: Tarjeta de Búsqueda -->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-search me-2"></i> Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('usuarios.index') }}" method="GET">
                <div class="row gx-3">

                    <div class="col-md-3 mb-3">
                        <label for="nombre" class="form-label">Nombres o Apellidos</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="{{ request('nombre') }}" placeholder="Buscar por Nombres...">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni"
                            value="{{ request('dni') }}" placeholder="Buscar por DNI...">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="text" class="form-control" id="correo" name="correo"
                            value="{{ request('correo') }}" placeholder="Buscar por Correo...">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="tipo" class="form-label">Tipo de Usuario</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">-- Todos los Tipos --</option>
                            @foreach ($tiposUsuario as $tipo)
                                <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIN: Formulario de Búsqueda -->


    <!-- INICIO: Tarjeta de Tabla de Usuarios -->
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lista de Usuarios</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalNuevoUsuario">
                        <i class="bi bi-plus-lg me-1"></i>
                        Registrar Nuevo Usuario
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th scope="col">Nombres</th>
                                    <th scope="col">Apellidos</th>
                                    <th scope="col">DNI</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Almacén</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $usuario->nombres }}</td>
                                        <td>{{ $usuario->apellidos }}</td>
                                        <td>{{ $usuario->dni }}</td>
                                        <td>{{ $usuario->correo }}</td>
                                        <td>{{ $usuario->telefono ?? 'N/A' }}</td>
                                        <td>{{ $usuario->almacen->nombre ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($usuario->tipo == 'admin') bg-danger
                                                @elseif($usuario->tipo == 'almacen') bg-warning text-dark
                                                @elseif($usuario->tipo == 'user') bg-info
                                                @else bg-secondary @endif">
                                                {{ $usuario->tipo }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-info btn-md btn-edit" title="Editar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditUsuario-{{ $usuario->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <button type="button" class="btn btn-danger btn-md btn-delete" title="Eliminar"
                                                data-delete-url="{{ route('usuarios.destroy', $usuario) }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No se encontraron usuarios con los filtros seleccionados.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $usuarios->links('vendor.pagination.paginacion') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Tarjeta de Tabla de Usuarios -->


    <!-- Formulario oculto para Eliminar (se usa con JS) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>


    <!-- INICIO: Modal para Nuevo Usuario -->
    <div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-labelledby="modalNuevoUsuarioLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoUsuarioLabel">Registrar Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Creación -->
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    <!-- Campo oculto para identificar el formulario en caso de error de validación -->
                    <input type="hidden" name="form_type" value="create_usuario">

                    <div class="modal-body">
                        <div class="row gx-3">

                            <div class="col-md-6 mb-3">
                                <label for="nombres_new" class="form-label">Nombres (*)</label>
                                <input type="text" class="form-control @error('nombres', 'create_usuario') is-invalid @enderror"
                                    id="nombres_new" name="nombres" value="{{ old('nombres') }}" required
                                    placeholder="Ingrese nombres">
                                @error('nombres', 'create_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="apellidos_new" class="form-label">Apellidos (*)</label>
                                <input type="text" class="form-control @error('apellidos', 'create_usuario') is-invalid @enderror"
                                    id="apellidos_new" name="apellidos" value="{{ old('apellidos') }}" required
                                    placeholder="Ingrese apellidos">
                                @error('apellidos', 'create_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="dni_new" class="form-label">DNI (*)</label>
                                <input type="text" class="form-control @error('dni', 'create_usuario') is-invalid @enderror"
                                    id="dni_new" name="dni" value="{{ old('dni') }}" required
                                    placeholder="Ingrese DNI">
                                @error('dni', 'create_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="telefono_new" class="form-label">Teléfono</label>
                                <input type="text" class="form-control @error('telefono', 'create_usuario') is-invalid @enderror"
                                    id="telefono_new" name="telefono" value="{{ old('telefono') }}"
                                    placeholder="Ingrese teléfono">
                                @error('telefono', 'create_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="almacen_id_new" class="form-label">Almacén (*)</label>
                                <select class="form-select @error('almacen_id', 'create_usuario') is-invalid @enderror" id="almacen_id_new" name="almacen_id" required>
                                    <option value="" disabled selected>-- Seleccione almacén --</option>
                                    @foreach ($almacenes as $almacen)
                                        <option value="{{ $almacen->id }}" {{ old('almacen_id') == $almacen->id ? 'selected' : '' }}>
                                            {{ $almacen->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('almacen_id', 'create_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="correo_new" class="form-label">Correo Electrónico (*)</label>
                                <input type="email" class="form-control @error('correo', 'create_usuario') is-invalid @enderror"
                                    id="correo_new" name="correo" value="{{ old('correo') }}" required
                                    placeholder="ejemplo@correo.com">
                                @error('correo', 'create_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipo_new" class="form-label">Tipo de Usuario (*)</label>
                                <select class="form-select @error('tipo', 'create_usuario') is-invalid @enderror" id="tipo_new" name="tipo" required>
                                    <option value="" disabled selected>-- Seleccione tipo --</option>
                                    @foreach ($tiposUsuario as $tipo)
                                        <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>
                                            {{ $tipo }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo', 'create_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="clave_new" class="form-label">Contraseña (*)</label>
                                <input type="password" class="form-control @error('clave', 'create_usuario') is-invalid @enderror"
                                    id="clave_new" name="clave" required placeholder="Mínimo 8 caracteres">
                                @error('clave', 'create_usuario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="clave_confirmation_new" class="form-label">Confirmar Contraseña (*)</label>
                                <input type="password" class="form-control" id="clave_confirmation_new"
                                    name="clave_confirmation" required placeholder="Repita la contraseña">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Nuevo Usuario -->


    <!-- INICIO: Modales para Editar Usuario (Generados dinámicamente) -->
    @foreach ($usuarios as $usuario)
        <div class="modal fade" id="modalEditUsuario-{{ $usuario->id }}" tabindex="-1"
            aria-labelledby="modalEditUsuarioLabel-{{ $usuario->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditUsuarioLabel-{{ $usuario->id }}">Editar Usuario: {{ $usuario->nombres }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Formulario de Edición -->
                    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Campo oculto para identificar el formulario en caso de error de validación -->
                        <input type="hidden" name="form_type" value="edit_usuario">

                        <div class="modal-body">
                            <div class="row gx-3">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombres (*)</label>
                                    <input type="text" class="form-control @error('nombres', 'edit_usuario_' . $usuario->id) is-invalid @enderror"
                                        name="nombres" value="{{ old('nombres', $usuario->nombres) }}" required
                                        placeholder="Ingrese nombres">
                                    @error('nombres', 'edit_usuario_' . $usuario->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Apellidos (*)</label>
                                    <input type="text" class="form-control @error('apellidos', 'edit_usuario_' . $usuario->id) is-invalid @enderror"
                                        name="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" required
                                        placeholder="Ingrese apellidos">
                                    @error('apellidos', 'edit_usuario_' . $usuario->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">DNI (*)</label>
                                    <input type="text" class="form-control @error('dni', 'edit_usuario_' . $usuario->id) is-invalid @enderror"
                                        name="dni" value="{{ old('dni', $usuario->dni) }}" required
                                        placeholder="Ingrese DNI">
                                    @error('dni', 'edit_usuario_' . $usuario->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control @error('telefono', 'edit_usuario_' . $usuario->id) is-invalid @enderror"
                                        name="telefono" value="{{ old('telefono', $usuario->telefono) }}"
                                        placeholder="Ingrese teléfono">
                                    @error('telefono', 'edit_usuario_' . $usuario->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Almacén (*)</label>
                                    <select class="form-select @error('almacen_id', 'edit_usuario_' . $usuario->id) is-invalid @enderror" name="almacen_id" required>
                                        <option value="" disabled>-- Seleccione almacén --</option>
                                        @foreach ($almacenes as $almacen)
                                            <option value="{{ $almacen->id }}" {{ (old('almacen_id') ?? $usuario->almacen_id) == $almacen->id ? 'selected' : '' }}>
                                                {{ $almacen->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('almacen_id', 'edit_usuario_' . $usuario->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Correo Electrónico (*)</label>
                                    <input type="email" class="form-control @error('correo', 'edit_usuario_' . $usuario->id) is-invalid @enderror"
                                        name="correo" value="{{ old('correo', $usuario->correo) }}" required
                                        placeholder="ejemplo@correo.com">
                                    @error('correo', 'edit_usuario_' . $usuario->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo de Usuario (*)</label>
                                    <select class="form-select @error('tipo', 'edit_usuario_' . $usuario->id) is-invalid @enderror" name="tipo" required>
                                        <option value="" disabled>-- Seleccione tipo --</option>
                                        @foreach ($tiposUsuario as $tipo)
                                            <option value="{{ $tipo }}" {{ (old('tipo') ?? $usuario->tipo) == $tipo ? 'selected' : '' }}>
                                                {{ $tipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipo', 'edit_usuario_' . $usuario->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <hr class="my-3">
                                <p class="text-muted">Deje los campos de contraseña en blanco si no desea cambiarla.</p>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nueva Contraseña</label>
                                    <input type="password" class="form-control @error('clave', 'edit_usuario_' . $usuario->id) is-invalid @enderror"
                                        name="clave" placeholder="Mínimo 8 caracteres">
                                    @error('clave', 'edit_usuario_' . $usuario->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirmar Nueva Contraseña</label>
                                    <input type="password" class="form-control"
                                        name="clave_confirmation" placeholder="Repita la nueva contraseña">
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- FIN: Modales para Editar Usuario -->

@endsection

{{-- INICIO: Scripts de la página --}}
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- 1. ALERTA DE ÉXITO/ERROR/AVISO (SweetAlert2) ---
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}'
                });
            @endif

            @if (session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Aviso',
                    text: '{{ session('warning') }}'
                });
            @endif


            // --- 2. Lógica para Botones de ELIMINAR ---
            const deleteForm = document.getElementById('deleteForm');
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevenir acción por defecto

                    const deleteUrl = this.getAttribute('data-delete-url');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esta acción! Asegúrate de que el usuario no tenga registros asociados.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, ¡eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Enviar el formulario oculto a la ruta de eliminación
                            deleteForm.setAttribute('action', deleteUrl);
                            deleteForm.submit();
                        }
                    });
                });
            });


            // --- 3. MANEJO DE ERRORES de VALIDACIÓN DEL MODAL ---
            
            // Re-abrir modal de CREAR si falla la validación
            @if ($errors->hasBag('create_usuario'))
                var modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevoUsuario'));
                modalNuevo.show();
            @endif

            // Re-abrir modal de EDICIÓN si falla la validación
            @if ($errors->any())
                @php
                    $errorBagName = '';
                    foreach ($errors->getBags() as $bagName => $bag) {
                        if (str_starts_with($bagName, 'edit_usuario_')) {
                            $errorBagName = $bagName;
                            break;
                        }
                    }
                @endphp

                @if ($errorBagName)
                    // Extraer el ID del usuario del nombre del error bag
                    @php $usuarioId = str_replace('edit_usuario_', '', $errorBagName); @endphp
                    var modalId = 'modalEditUsuario-' + '{{ $usuarioId }}';
                    var modalEdit = document.getElementById(modalId);
                    if(modalEdit) {
                        var modalInstance = new bootstrap.Modal(modalEdit);
                        modalInstance.show();
                    }
                @endif
            @endif


        });
    </script>
@endsection
{{-- FIN: Scripts de la página --}}