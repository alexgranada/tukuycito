@extends('plantillas.app')
@section('titulo', 'Tukuycito - Obras')
@section('nombre', 'Gestión de Obras')
@section('css')
    {{-- CSS Específico si es necesario --}}
@endsection
@section('contenido')

    <!-- INICIO: Tarjeta de Búsqueda Avanzada -->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-search me-2"></i> Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('obras.index') }}" method="GET">
                <div class="row gx-3">

                    <div class="col-md-3 mb-3">
                        <label for="meta" class="form-label">Meta</label>
                        <input type="text" class="form-control" id="meta" name="meta"
                            value="{{ request('meta') }}" placeholder="Buscar por Meta...">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nombre" class="form-label">Nombre de Obra</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="{{ request('nombre') }}" placeholder="Buscar por Nombre...">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="responsable" class="form-label">Responsable</label>
                        <input type="text" class="form-control" id="responsable" name="responsable"
                            value="{{ request('responsable') }}" placeholder="Buscar por Responsable...">
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        <a href="{{ route('obras.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIN: Formulario de Búsqueda Avanzada -->


    <!-- INICIO: Tarjeta de Tabla de Obras -->
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lista de Obras</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalNuevaObra">
                        <i class="bi bi-plus-lg me-1"></i>
                        Registrar Nueva Obra
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th scope="col">Meta</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Responsable</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Ubicación</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($obras as $obra)
                                    <tr>
                                        <td>{{ $obra->meta }}</td>
                                        <td>{{ $obra->nombre }}</td>
                                        <td>{{ $obra->responsable ?? 'N/A' }}</td>
                                        <td>{{ $obra->telefono ?? 'N/A' }}</td>
                                        <td>{{ $obra->ubicacion ?? 'N/A' }}</td>

                                        <td class="text-center">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-info btn-md btn-edit" title="Editar"
                                                data-bs-toggle="modal" data-bs-target="#modalEditObra"
                                                data-obra="{{ $obra->toJson() }}"
                                                data-update-url="{{ route('obras.update', $obra) }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <button type="button" class="btn btn-danger btn-md btn-delete" title="Eliminar"
                                                data-delete-url="{{ route('obras.destroy', $obra) }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            No se encontraron obras con los filtros seleccionados.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $obras->links('vendor.pagination.paginacion') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Tarjeta de Tabla de Obras -->


    <!-- Formulario oculto para Eliminar (se usa con JS) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>


    <!-- INICIO: Modal para Nueva Obra -->
    <div class="modal fade" id="modalNuevaObra" tabindex="-1" aria-labelledby="modalNuevaObraLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevaObraLabel">Registrar Nueva Obra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Creación -->
                <form action="{{ route('obras.store') }}" method="POST">
                    @csrf
                    <!-- Campo oculto para identificar el formulario en caso de error de validación -->
                    <input type="hidden" name="form_type" value="create_obra">

                    <div class="modal-body">
                        <div class="row gx-3">

                            <div class="col-md-4 mb-3">
                                <label for="nombre_new" class="form-label">Nombre de Obra (*)</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                    id="nombre_new" name="nombre" value="{{ old('nombre') }}" required
                                    placeholder="Nombre Del proyecto">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="meta_new" class="form-label">Meta (*)</label>
                                <input type="text" class="form-control @error('meta') is-invalid @enderror"
                                    id="meta_new" name="meta" value="{{ old('meta') }}" required
                                    placeholder="meta">
                                @error('meta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="responsable_new" class="form-label">Responsable</label>
                                <input type="text" class="form-control @error('responsable') is-invalid @enderror"
                                    id="responsable_new" name="responsable" value="{{ old('responsable') }}"
                                    placeholder="Responsable">
                                @error('responsable')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="telefono_new" class="form-label">Teléfono</label>
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                    id="telefono_new" name="telefono" value="{{ old('telefono') }}"
                                    placeholder="Teléfono">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="ubicacion_new" class="form-label">Ubicación</label>
                                <input type="text" class="form-control @error('ubicacion') is-invalid @enderror"
                                    id="ubicacion_new" name="ubicacion" value="{{ old('ubicacion') }}"
                                    placeholder=" ubicacion">
                                @error('ubicacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Obra</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Nueva Obra -->


    <!-- INICIO: Modal para Editar Obra -->
    <div class="modal fade" id="modalEditObra" tabindex="-1" aria-labelledby="modalEditObraLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditObraLabel">Editar Obra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Edición -->
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Campo oculto para identificar el formulario en caso de error de validación -->
                    <input type="hidden" name="form_type" value="edit_obra">

                    <div class="modal-body">
                        <div class="row gx-3">

                            <div class="col-md-4 mb-3">
                                <label for="nombre_edit" class="form-label">Nombre de Obra (*)</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                    id="nombre_edit" name="nombre" required placeholder="Nombre Del proyecto">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="meta_edit" class="form-label">Meta (*)</label>
                                <input type="text" class="form-control @error('meta') is-invalid @enderror"
                                    id="meta_edit" name="meta" required placeholder="meta">
                                @error('meta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="responsable_edit" class="form-label">Responsable</label>
                                <input type="text" class="form-control @error('responsable') is-invalid @enderror"
                                    id="responsable_edit" name="responsable" placeholder="Responsable">
                                @error('responsable')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 mb-3">
                                <label for="telefono_edit" class="form-label">Teléfono</label>
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                    id="telefono_edit" name="telefono" placeholder="Teléfono">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="ubicacion_edit" class="form-label">Ubicación</label>
                                <input type="text" class="form-control @error('ubicacion') is-invalid @enderror"
                                    id="ubicacion_edit" name="ubicacion" placeholder=" ubicacion">
                                @error('ubicacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Obra</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Editar Obra -->

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


            // --- 2. Lógica para Botones de EDITAR ---
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    // Rellenar el modal de edición
                    const obraData = JSON.parse(this.getAttribute('data-obra'));
                    const updateUrl = this.getAttribute('data-update-url');

                    const form = document.getElementById('editForm');
                    form.setAttribute('action', updateUrl);

                    // Rellenar campos del formulario de edición
                    document.getElementById('nombre_edit').value = obraData.nombre;
                    document.getElementById('meta_edit').value = obraData.meta;
                    document.getElementById('responsable_edit').value = obraData.responsable;
                    document.getElementById('telefono_edit').value = obraData.telefono;
                    document.getElementById('ubicacion_edit').value = obraData.ubicacion;
                });
            });


            // --- 3. Lógica para Botones de ELIMINAR ---
            const deleteForm = document.getElementById('deleteForm');
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevenir acción por defecto

                    const deleteUrl = this.getAttribute('data-delete-url');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esta acción! Asegúrate de que no tenga préstamos asociados.",
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


            // --- 4. MANEJO DE ERRORES de VALIDACIÓN DEL MODAL ---
            @if ($errors->any())
                @if (old('form_type') == 'create_obra')
                    var modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevaObra'));
                    modalNuevo.show();
                @elseif (old('form_type') == 'edit_obra')
                    // Solución simple: Mostrar alerta si falló la edición
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Validación',
                        text: 'La actualización falló. Revise los campos e intente editar de nuevo.'
                    });
                @elseif (old('form_type') != 'edit_obra')
                    var modalNuevo = new bootstrap.Modal(document.getElementById(
                        'modalNuevaObra'));
                    modalNuevo.show();
                @endif
            @endif

        });
    </script>
@endsection
{{-- FIN: Scripts de la página --}}
