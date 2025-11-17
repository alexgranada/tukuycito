@extends('plantillas.app')
@section('titulo', 'Tukuycito - Almacenes')
@section('nombre', 'Gestión de Almacenes')
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
            <form action="{{ route('almacen.index') }}" method="GET">
                <div class="row gx-3">

                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre del Almacén</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="{{ request('nombre') }}" placeholder="Buscar por Nombre...">
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        <a href="{{ route('almacen.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIN: Formulario de Búsqueda -->


    <!-- INICIO: Tarjeta de Tabla de Almacenes -->
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lista de Almacenes</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalNuevoAlmacen">
                        <i class="bi bi-plus-lg me-1"></i>
                        Registrar Nuevo Almacén
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($almacenes as $almacen)
                                    <tr>
                                        <td>{{ $almacen->id }}</td>
                                        <td>{{ $almacen->nombre }}</td>

                                        <td class="text-center">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-info btn-md btn-edit" title="Editar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditAlmacen-{{ $almacen->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <button type="button" class="btn btn-danger btn-md btn-delete" title="Eliminar"
                                                data-delete-url="{{ route('almacen.destroy', $almacen) }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            No se encontraron almacenes con los filtros seleccionados.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $almacenes->links('vendor.pagination.paginacion') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Tarjeta de Tabla de Almacenes -->


    <!-- Formulario oculto para Eliminar (se usa con JS) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>


    <!-- INICIO: Modal para Nuevo Almacén -->
    <div class="modal fade" id="modalNuevoAlmacen" tabindex="-1" aria-labelledby="modalNuevoAlmacenLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoAlmacenLabel">Registrar Nuevo Almacén</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Creación -->
                <form action="{{ route('almacen.store') }}" method="POST">
                    @csrf
                    <!-- Campo oculto para identificar el formulario en caso de error de validación -->
                    <input type="hidden" name="form_type" value="create_almacen">

                    <div class="modal-body">
                        <div class="row gx-3">

                            <div class="col-12 mb-3">
                                <label for="nombre_new" class="form-label">Nombre (*)</label>
                                <input type="text" class="form-control @error('nombre', 'create_almacen') is-invalid @enderror"
                                    id="nombre_new" name="nombre" value="{{ old('nombre') }}" required
                                    placeholder="Ingrese nombre del almacén">
                                @error('nombre', 'create_almacen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Almacén</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Nuevo Almacén -->


    <!-- INICIO: Modales para Editar Almacén (Generados dinámicamente) -->
    @foreach ($almacenes as $almacen)
        <div class="modal fade" id="modalEditAlmacen-{{ $almacen->id }}" tabindex="-1"
            aria-labelledby="modalEditAlmacenLabel-{{ $almacen->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditAlmacenLabel-{{ $almacen->id }}">Editar Almacén: {{ $almacen->nombre }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Formulario de Edición -->
                    <form action="{{ route('almacen.update', $almacen) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Campo oculto para identificar el formulario en caso de error de validación -->
                        <input type="hidden" name="form_type" value="edit_almacen">

                        <div class="modal-body">
                            <div class="row gx-3">

                                <div class="col-12 mb-3">
                                    <label class="form-label">Nombre (*)</label>
                                    <input type="text" class="form-control @error('nombre', 'edit_almacen_' . $almacen->id) is-invalid @enderror"
                                        name="nombre" value="{{ old('nombre', $almacen->nombre) }}" required
                                        placeholder="Ingrese nombre del almacén">
                                    @error('nombre', 'edit_almacen_' . $almacen->id) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Actualizar Almacén</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- FIN: Modales para Editar Almacén -->

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
                        text: "¡No podrás revertir esta acción! Asegúrate de que no esté en uso.",
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
            @if ($errors->hasBag('create_almacen'))
                var modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevoAlmacen'));
                modalNuevo.show();
            @endif

            // Re-abrir modal de EDICIÓN si falla la validación
            @if ($errors->any())
                @php
                    $errorBagName = '';
                    foreach ($errors->getBags() as $bagName => $bag) {
                        if (str_starts_with($bagName, 'edit_almacen_')) {
                            $errorBagName = $bagName;
                            break;
                        }
                    }
                @endphp

                @if ($errorBagName)
                    // Extraer el ID del almacen del nombre del error bag
                    @php $almacenId = str_replace('edit_almacen_', '', $errorBagName); @endphp
                    var modalId = 'modalEditAlmacen-' + '{{ $almacenId }}';
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