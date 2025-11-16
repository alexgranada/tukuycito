@extends('plantillas.app')
@section('titulo', 'Tukuycito - Productos')
@section('nombre', 'Gestión de Productos')
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
            <form action="{{ route('productos.index') }}" method="GET">
                <div class="row gx-3">

                    <div class="col-md-3 mb-3">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo"
                            value="{{ request('codigo') }}" placeholder="Buscar por Código...">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="nombre" class="form-label">Descripción (Nombre)</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="{{ request('nombre') }}" placeholder="Buscar por Descripción...">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="tipo" class="form-label">Tipo de Producto</label>
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="">-- Todos los Tipos --</option>
                            @isset($tipos)
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                        {{ ucfirst($tipo) }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIN: Formulario de Búsqueda Avanzada -->


    <!-- INICIO: Tarjeta de Tabla de Productos -->
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lista de Productos</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalNuevoProducto">
                        <i class="bi bi-plus-lg me-1"></i>
                        Registrar Nuevo Producto
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Descripción (Nombre)</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Uni. Medida</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->codigo }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->tipo ?? 'No especificado' }}</td>
                                        <td>{{ $producto->uni_medida ?? 'N/A' }}</td>
                                        <td>
                                            <img src="{{ $producto->foto ? Storage::url($producto->foto) : 'https://placehold.co/60x60/eee/ccc?text=Sin+Foto' }}"
                                                alt="Foto de {{ $producto->nombre }}"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"
                                                onerror="this.src='https://placehold.co/60x60/eee/ccc?text=Error';">
                                        </td>

                                        <td class="text-center">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-info btn-md btn-edit" title="Editar"
                                                data-bs-toggle="modal" data-bs-target="#modalEditProducto"
                                                data-producto="{{ $producto->toJson() }}"
                                                data-update-url="{{ route('productos.update', $producto) }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <button type="button" class="btn btn-danger btn-md btn-delete"
                                                title="Eliminar"
                                                data-delete-url="{{ route('productos.destroy', $producto) }}">
                                                <i class="bi bi-trash3"></i> {{-- Icono cambiado a basura --}}
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            No se encontraron productos con los filtros seleccionados.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $productos->links('vendor.pagination.paginacion') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Tarjeta de Tabla de Productos -->


    <!-- Formulario oculto para Eliminar (se usa con JS) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>


    <!-- INICIO: Modal para Nuevo Producto -->
    <div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-labelledby="modalNuevoProductoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoProductoLabel">Registrar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Creación -->
                <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Campo oculto para identificar el formulario en caso de error de validación -->
                    <input type="hidden" name="form_type" value="create_producto">

                    <div class="modal-body">
                        <div class="row gx-3">

                            <div class="col-md-3 mb-3">
                                <label for="codigo_new" class="form-label">Código (*)</label>
                                <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                    id="codigo_new" name="codigo" value="{{ old('codigo') }}" required>
                                @error('codigo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-9 mb-3">
                                <label for="nombre_new" class="form-label">Descripción (Nombre) (*)</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                    id="nombre_new" name="nombre" value="{{ old('nombre') }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipo_new" class="form-label">Tipo</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option value="">-- Seleccione un Tipo --</option>
                                    @isset($tipos)
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo }}"
                                                {{ old('tipo') == $tipo ? 'selected' : '' }}>
                                                {{ ucfirst($tipo) }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="uni_medida_new" class="form-label">Unidad de Medida</label>
                                <select name="uni_medida" id="uni_medida_new" class="form-control">
                                    <option value="">-- Seleccione una Unidad --</option>
                                    <option value="UND" {{ old('uni_medida') == 'UND' ? 'selected' : '' }}>UND</option>
                                    <option value="M2" {{ old('uni_medida') == 'M2' ? 'selected' : '' }}>M2</option>
                                    <option value="GLB" {{ old('uni_medida') == 'GLB' ? 'selected' : '' }}>GLB</option>
                                    <option value="KG" {{ old('uni_medida') == 'KG' ? 'selected' : '' }}>KG</option>
                                    <option value="LT" {{ old('uni_medida') == 'LT' ? 'selected' : '' }}>LT</option>
                                    <option value="ML" {{ old('uni_medida') == 'ML' ? 'selected' : '' }}>ML</option>
                                </select>
                                
                                @error('uni_medida')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="foto_new" class="form-label">Foto (Opcional)</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    id="foto_new" name="foto" accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Nuevo Producto -->


    <!-- INICIO: Modal para Editar Producto -->
    <div class="modal fade" id="modalEditProducto" tabindex="-1" aria-labelledby="modalEditProductoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditProductoLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Edición -->
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Campo oculto para identificar el formulario en caso de error de validación -->
                    <input type="hidden" name="form_type" value="edit_producto">

                    <div class="modal-body">
                        <div class="row gx-3">

                            <div class="col-md-3 mb-3">
                                <label for="codigo_edit" class="form-label">Código (*)</label>
                                <input type="text" class="form-control @error('codigo') is-invalid @enderror"
                                    id="codigo_edit" name="codigo" required>
                                @error('codigo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-9 mb-3">
                                <label for="nombre_edit" class="form-label">Descripción (Nombre) (*)</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                    id="nombre_edit" name="nombre" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipo_edit" class="form-label">Tipo</label>
                                <select name="tipo" id="tipo_edit" class="form-control">
                                    <option value="">-- Seleccione un Tipo --</option>
                                    @isset($tipos)
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo }}">
                                                {{ ucfirst($tipo) }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="uni_medida_edit" class="form-label">Unidad de Medida</label>
                                <select name="uni_medida" id="uni_medida_edit" class="form-control">
                                    <option value="">-- Seleccione una Unidad --</option>
                                    <option value="UND">UND</option>
                                    <option value="M2">M2</option>
                                    <option value="GLB">GLB</option>
                                    <option value="KG">KG</option>
                                    <option value="LT">LT</option>
                                    <option value="ML">ML</option>
                                </select>
                                
                                @error('uni_medida')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="foto_edit" class="form-label">Actualizar Foto (Opcional)</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    id="foto_edit" name="foto" accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Foto Actual</label>
                                <div>
                                    <img id="foto_preview"
                                        src="https://placehold.co/100x100/eee/ccc?text=Sin+Foto"
                                        alt="Foto Actual"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Editar Producto -->

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
                    const productoData = JSON.parse(this.getAttribute('data-producto'));
                    const updateUrl = this.getAttribute('data-update-url');

                    const form = document.getElementById('editForm');
                    form.setAttribute('action', updateUrl);

                    // Rellenar campos del formulario de edición
                    document.getElementById('codigo_edit').value = productoData.codigo;
                    document.getElementById('nombre_edit').value = productoData.nombre;
                    document.getElementById('tipo_edit').value = productoData.tipo;
                    document.getElementById('uni_medida_edit').value = productoData.uni_medida;

                    // Mostrar la foto actual
                    const preview = document.getElementById('foto_preview');
                    if (productoData.foto) {
                        // Construimos la URL pública. Asumimos que 'storage' está linkeado.
                        preview.src = `{{ Storage::url('') }}${productoData.foto}`;
                    } else {
                        preview.src = 'https://placehold.co/100x100/eee/ccc?text=Sin+Foto';
                    }
                    
                    // Limpiar el campo de archivo 'foto' por si acaso
                    document.getElementById('foto_edit').value = null;
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
                        text: "¡No podrás revertir esta acción!",
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


            // --- 4. MANEJO DE ERRORES DE VALIDACIÓN DEL MODAL ---
            // Si hay errores de validación, Laravel recargará la página.
            // Necesitamos reabrir el modal correcto.
            @if ($errors->any())
                @if (old('form_type') == 'create_producto')
                    var modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevoProducto'));
                    modalNuevo.show();
                @elseif (old('form_type') == 'edit_producto')
                    // Esto es más complejo porque necesitamos re-poblar los datos
                    // y la URL de acción del formulario de edición.
                    // Mostraremos el modal, pero la data-producto no estará disponible.
                    // El usuario tendrá que re-abrirlo manualmente.
                    // NOTA: Para una UX perfecta, esto requeriría JS más avanzado o
                    // enviar el ID del producto que falló en 'old()'.
                    // Por simplicidad, reabrimos el modal de "Nuevo" si falla el "Editar"
                    // o, mejor aún, mostramos una alerta genérica de validación.

                    // Solución simple: Mostrar alerta si falló la edición
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Validación',
                        text: 'La actualización falló. Revise los campos e intente editar de nuevo.'
                    });

                    // Si la validación de 'create' falló, sí podemos reabrirlo:
                @elseif (old('form_type') != 'edit_producto')
                    var modalNuevo = new bootstrap.Modal(document.getElementById(
                        'modalNuevoProducto'));
                    modalNuevo.show();
                @endif
            @endif

        });
    </script>
@endsection
{{-- FIN: Scripts de la página --}}