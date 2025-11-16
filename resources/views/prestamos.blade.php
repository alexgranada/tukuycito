@extends('plantillas.app')
@section('titulo', 'Tukuycito - Préstamos')
@section('nombre', 'Gestión de Préstamos')
@section('css')
    <style>
        /* --- Estilos para el buscador de productos --- */
        .search-results-wrapper {
            position: relative;
        }

        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 0 0 0.375rem 0.375rem;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1056;
            /* Encima del modal */
            display: none;
            /* Oculto por defecto */
        }

        .search-result-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }

        .search-result-item:hover {
            background: #f8f9fa;
        }

        .search-result-item img {
            width: 40px;
            height: 40px;
            border-radius: 0.25rem;
            margin-right: 0.75rem;
            object-fit: cover;
        }

        .search-result-info {
            line-height: 1.3;
        }

        .search-result-info strong {
            display: block;
            color: #333;
        }

        .search-result-info small {
            color: #6c757d;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        /* --- Estilos para la tabla de detalles --- */
        .tabla-detalles input[type="number"] {
            width: 100px;
            /* Ancho fijo para cantidad y precio */
        }

        .detalle-producto-nombre {
            display: block;
            font-weight: 500;
        }

        .detalle-producto-codigo {
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* --- Loader para AJAX --- */
        .loader-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }
    </style>
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
            <form action="{{ route('prestamos.index') }}" method="GET">
                <div class="row gx-3">

                    <!-- Filtro Almacén (Solo Admin) -->
                    @if (Auth::user()->tipo == 'admin' && isset($almacenes))
                        <div class="col-md-4 mb-3">
                            <label for="almacen_id_filtro" class="form-label">Almacén</label>
                            <select class="form-select" id="almacen_id_filtro" name="almacen_id">
                                <option value="">-- Todos los Almacenes --</option>
                                @foreach ($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}"
                                        {{ request('almacen_id') == $almacen->id ? 'selected' : '' }}>
                                        {{ $almacen->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Filtro Obra -->
                    <div class="col-md-4 mb-3">
                        <label for="obra_id_filtro" class="form-label">Obra</label>
                        <select class="form-select" id="obra_id_filtro" name="obra_id">
                            <option value="">-- Todas las Obras --</option>
                            @foreach ($obras as $obra)
                                <option value="{{ $obra->id }}" {{ request('obra_id') == $obra->id ? 'selected' : '' }}>
                                    {{ $obra->nombre }} (Meta: {{ $obra->meta }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro Estado -->
                    <div class="col-md-4 mb-3">
                        <label for="estado_filtro" class="form-label">Estado</label>
                        <select class="form-select" id="estado_filtro" name="estado">
                            <option value="">-- Todos los Estados --</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>
                                    {{ ucfirst($estado) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro Fechas -->
                    <div class="col-md-3 mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha Préstamo (Desde)</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                            value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="fecha_fin" class="form-label">Fecha Préstamo (Hasta)</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                            value="{{ request('fecha_fin') }}">
                    </div>

                    <!-- Filtro N° Acta -->
                    <div class="col-md-3 mb-3">
                        <label for="numero_acta_filtro" class="form-label">N° de Acta</label>
                        <input type="text" class="form-control" id="numero_acta_filtro" name="numero_acta"
                            value="{{ request('numero_acta') }}" placeholder="Buscar por N° de Acta...">
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        <a href="{{ route('prestamos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIN: Formulario de Búsqueda Avanzada -->


    <!-- INICIO: Tarjeta de Tabla de Préstamos -->
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lista de Préstamos</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalNuevoPrestamo">
                        <i class="bi bi-plus-lg me-1"></i>
                        Registrar Nuevo Préstamo
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0 align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Almacén</th>
                                    <th scope="col">Obra</th>
                                    <th scope="col">N° Acta</th>
                                    <th scope="col">Fecha Préstamo</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($prestamos as $prestamo)
                                    <tr>
                                        <td>{{ $prestamo->almacen->nombre ?? 'N/A' }}</td>
                                        <td>
                                            <span
                                                class="detalle-producto-nombre">{{ $prestamo->obra->nombre ?? 'N/A' }}</span>
                                            <span class="detalle-producto-codigo">Meta:
                                                {{ $prestamo->obra->meta ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ $prestamo->numero_acta ?? 'Sin Acta' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($prestamo->fecha_prestamo)->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($prestamo->estado == 'prestado')
                                                <span class="badge bg-warning text-dark text-white">Prestado</span>
                                            @elseif($prestamo->estado == 'devuelto')
                                                <span class="badge bg-success">Devuelto</span>
                                            @elseif($prestamo->estado == 'observado')
                                                <span class="badge bg-danger">Observado</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($prestamo->estado) }}</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <!-- Botón Ver Acta -->
                                            @if ($prestamo->acta)
                                                <a href="{{ Storage::url($prestamo->acta) }}" target="_blank"
                                                    class="btn btn-secondary btn-md" title="Ver Acta">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                            @endif

                                            <!-- Botón Ver Detalles -->
                                            <button type="button" class="btn btn-success btn-md btn-view-details"
                                                title="Ver Detalles" data-bs-toggle="modal"
                                                data-bs-target="#modalVerDetalles"
                                                data-details-url="{{ route('prestamos.getDetalles', $prestamo) }}"
                                                data-prestamo-info="Préstamo a: {{ $prestamo->obra->nombre }} ({{ \Carbon\Carbon::parse($prestamo->fecha_prestamo)->format('d/m/Y') }})">
                                                <i class="bi bi-list-check"></i>
                                            </button>

                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-info btn-md btn-edit" title="Editar"
                                                data-bs-toggle="modal" data-bs-target="#modalEditPrestamo"
                                                data-prestamo="{{ $prestamo->toJson() }}"
                                                data-update-url="{{ route('prestamos.update', $prestamo) }}"
                                                data-details-url="{{ route('prestamos.getDetalles', $prestamo) }}"
                                                data-acta-url="{{ $prestamo->acta ? Storage::url($prestamo->acta) : '' }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <button type="button" class="btn btn-danger btn-md btn-delete"
                                                title="Eliminar"
                                                data-delete-url="{{ route('prestamos.destroy', $prestamo) }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            No se encontraron préstamos con los filtros seleccionados.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $prestamos->links('vendor.pagination.paginacion') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Tarjeta de Tabla de Préstamos -->


    <!-- Formulario oculto para Eliminar (se usa con JS) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>


    <!-- INICIO: Modal para Nuevo Préstamo -->
    <div class="modal fade" id="modalNuevoPrestamo" tabindex="-1" aria-labelledby="modalNuevoPrestamoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl"> {{-- Cambiado a modal-xl --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoPrestamoLabel">Registrar Nuevo Préstamo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Creación -->
                <form action="{{ route('prestamos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="form_type" value="create_prestamo">

                    <div class="modal-body">
                        <h5>1. Datos del Préstamo</h5>
                        <div class="row gx-3">

                            <!-- Campo Almacén (Select o Hidden) -->
                            <div class="col-md-6 mb-3">
                                <label for="almacen_id_new" class="form-label">Almacén (*)</label>
                                @if (Auth::user()->tipo == 'admin')
                                    <select class="form-select @error('almacen_id') is-invalid @enderror"
                                        id="almacen_id_new" name="almacen_id" required>
                                        <option value="">-- Seleccione un Almacén --</option>
                                        @foreach ($almacenes as $almacen)
                                            <option value="{{ $almacen->id }}"
                                                {{ old('almacen_id') == $almacen->id ? 'selected' : '' }}>
                                                {{ $almacen->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('almacen_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @else
                                    <!-- Usuario Normal: Ve su almacén, deshabilitado -->
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->almacen->nombre ?? 'Almacén no asignado' }}" disabled
                                        placeholder="Almacén del usuario">
                                    <input type="hidden" name="almacen_id" value="{{ Auth::user()->almacen_id }}">
                                @endif
                            </div>

                            <!-- Campo Obra -->
                            <div class="col-md-6 mb-3">
                                <label for="obra_id_new" class="form-label">Obra (*)</label>
                                <select class="form-select @error('obra_id') is-invalid @enderror" id="obra_id_new"
                                    name="obra_id" required>
                                    <option value="">-- Seleccione una Obra --</option>
                                    @foreach ($obras as $obra)
                                        <option value="{{ $obra->id }}"
                                            {{ old('obra_id') == $obra->id ? 'selected' : '' }}>
                                            {{ $obra->nombre }} (Meta: {{ $obra->meta }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('obra_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fechas -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_prestamo_new" class="form-label">Fecha Préstamo (*)</label>
                                <input type="date"
                                    class="form-control @error('fecha_prestamo') is-invalid @enderror"
                                    id="fecha_prestamo_new" name="fecha_prestamo"
                                    value="{{ old('fecha_prestamo', date('Y-m-d')) }}" required>
                                @error('fecha_prestamo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_devolucion_new" class="form-label">Fecha Devolución (Opcional)</label>
                                <input type="date"
                                    class="form-control @error('fecha_devolucion') is-invalid @enderror"
                                    id="fecha_devolucion_new" name="fecha_devolucion"
                                    value="{{ old('fecha_devolucion') }}">
                                @error('fecha_devolucion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo y Estado -->
                            <div class="col-md-6 mb-3">
                                <label for="tipo_prestamo_new" class="form-label">Tipo de Préstamo (*)</label>
                                <select class="form-select @error('tipo_prestamo') is-invalid @enderror"
                                    id="tipo_prestamo_new" name="tipo_prestamo" required>
                                    <option value="temporal"
                                        {{ old('tipo_prestamo') == 'temporal' ? 'selected' : '' }}>
                                        Temporal</option>
                                    <option value="definitivo"
                                        {{ old('tipo_prestamo') == 'definitivo' ? 'selected' : '' }}>Definitivo</option>
                                </select>
                                @error('tipo_prestamo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado_new" class="form-label">Estado (*)</label>
                                <select class="form-select @error('estado') is-invalid @enderror" id="estado_new"
                                    name="estado" required>
                                    <option value="prestado"
                                        {{ old('estado', 'prestado') == 'prestado' ? 'selected' : '' }}>Prestado
                                    </option>
                                    <option value="devuelto" {{ old('estado') == 'devuelto' ? 'selected' : '' }}>Devuelto
                                    </option>
                                    <option value="observado" {{ old('estado') == 'observado' ? 'selected' : '' }}>
                                        Observado</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Acta -->
                            <div class="col-md-6 mb-3">
                                <label for="numero_acta_new" class="form-label">N° de Acta (Opcional)</label>
                                <input type="text" class="form-control @error('numero_acta') is-invalid @enderror"
                                    id="numero_acta_new" name="numero_acta" value="{{ old('numero_acta') }}"
                                    placeholder="Ej: ACTA-001-2025">
                                @error('numero_acta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="acta_new" class="form-label">Subir Acta (Opcional)</label>
                                <input type="file" class="form-control @error('acta') is-invalid @enderror"
                                    id="acta_new" name="acta" accept=".pdf,.jpg,.jpeg,.png">
                                @error('acta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Observaciones -->
                            <div class="col-12 mb-3">
                                <label for="observaciones_new" class="form-label">Observaciones (Opcional)</label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones_new"
                                    name="observaciones" rows="2" placeholder="Añadir observaciones...">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5>2. Detalle de Productos</h5>
                        @error('detalles')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <!-- Buscador de Productos -->
                        <div class="row gx-2 mb-3">
                            <div class="col-md-7">
                                <label for="producto_search_new" class="form-label">Buscar Producto (por Código o
                                    Nombre)</label>
                                <div class="search-results-wrapper">
                                    {{-- CAMBIO: Añadido input-group --}}
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="producto_search_new"
                                            placeholder="Escriba para buscar productos...">
                                        <button class="btn btn-outline-secondary" type="button" id="btn_search_new">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    <div class="search-results" id="search_results_new">
                                        <!-- Los resultados de AJAX se insertarán aquí -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#modalNuevoProductoRapido">
                                    <i class="bi bi-plus-circle"></i> Agregar Producto No Encontrado
                                </button>
                            </div>
                        </div>

                        <!-- Tabla de Productos Seleccionados -->
                        <div class="table-responsive">
                            <table class="table table-bordered tabla-detalles">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50%;">Producto</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio Unit. (S/)</th>
                                        <th scope="col" class="text-center">Quitar</th>
                                    </tr>
                                </thead>
                                <tbody id="detalle_table_body_new">
                                    <!-- Filas de productos se añaden con JS aquí -->
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Préstamo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Nuevo Préstamo -->


    <!-- INICIO: Modal para Editar Préstamo -->
    <div class="modal fade" id="modalEditPrestamo" tabindex="-1" aria-labelledby="modalEditPrestamoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl"> {{-- Cambiado a modal-xl --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPrestamoLabel">Editar Préstamo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Edición -->
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_type" value="edit_prestamo">

                    <div class="modal-body">
                        <h5>1. Datos del Préstamo</h5>
                        <div class="row gx-3">

                            <!-- Campo Almacén (Select o Hidden) -->
                            <div class="col-md-6 mb-3">
                                <label for="almacen_id_edit" class="form-label">Almacén (*)</label>
                                @if (Auth::user()->tipo == 'admin')
                                    <select class="form-select @error('almacen_id') is-invalid @enderror"
                                        id="almacen_id_edit" name="almacen_id" required>
                                        <option value="">-- Seleccione un Almacén --</option>
                                        @foreach ($almacenes as $almacen)
                                            <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('almacen_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                @else
                                    <input type="text" class="form-control"
                                        value="{{ Auth::user()->almacen->nombre ?? 'Almacén no asignado' }}" disabled
                                        placeholder="Almacén del usuario">
                                    <input type="hidden" id="almacen_id_edit_hidden" name="almacen_id">
                                @endif
                            </div>

                            <!-- Campo Obra -->
                            <div class="col-md-6 mb-3">
                                <label for="obra_id_edit" class="form-label">Obra (*)</label>
                                <select class="form-select @error('obra_id') is-invalid @enderror" id="obra_id_edit"
                                    name="obra_id" required>
                                    <option value="">-- Seleccione una Obra --</option>
                                    @foreach ($obras as $obra)
                                        <option value="{{ $obra->id }}">
                                            {{ $obra->nombre }} (Meta: {{ $obra->meta }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('obra_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fechas -->
                            <div class="col-md-6 mb-3">
                                <label for="fecha_prestamo_edit" class="form-label">Fecha Préstamo (*)</label>
                                <input type="date"
                                    class="form-control @error('fecha_prestamo') is-invalid @enderror"
                                    id="fecha_prestamo_edit" name="fecha_prestamo" required>
                                @error('fecha_prestamo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_devolucion_edit" class="form-label">Fecha Devolución (Opcional)</label>
                                <input type="date"
                                    class="form-control @error('fecha_devolucion') is-invalid @enderror"
                                    id="fecha_devolucion_edit" name="fecha_devolucion">
                                @error('fecha_devolucion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo y Estado -->
                            <div class="col-md-6 mb-3">
                                <label for="tipo_prestamo_edit" class="form-label">Tipo de Préstamo (*)</label>
                                <select class="form-select @error('tipo_prestamo') is-invalid @enderror"
                                    id="tipo_prestamo_edit" name="tipo_prestamo" required>
                                    <option value="temporal">Temporal</option>
                                    <option value="definitivo">Definitivo</option>
                                </select>
                                @error('tipo_prestamo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado_edit" class="form-label">Estado (*)</label>
                                <select class="form-select @error('estado') is-invalid @enderror" id="estado_edit"
                                    name="estado" required>
                                    <option value="prestado">Prestado</option>
                                    <option value="devuelto">Devuelto</option>
                                    <option value="observado">Observado</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Acta -->
                            <div class="col-md-6 mb-3">
                                <label for="numero_acta_edit" class="form-label">N° de Acta (Opcional)</label>
                                <input type="text" class="form-control @error('numero_acta') is-invalid @enderror"
                                    id="numero_acta_edit" name="numero_acta" placeholder="Ej: ACTA-001-2025">
                                @error('numero_acta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="acta_edit" class="form-label">Actualizar Acta (Opcional)</label>
                                <input type="file" class="form-control @error('acta') is-invalid @enderror"
                                    id="acta_edit" name="acta" accept=".pdf,.jpg,.jpeg,.png">
                                @error('acta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Acta Actual -->
                            <div class="col-12 mb-3" id="acta_actual_wrapper_edit" style="display: none;">
                                <label class="form-label">Acta Actual</label>
                                <div>
                                    <a id="acta_actual_link_edit" href="#" target="_blank"
                                        class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-file-earmark-text me-1"></i> Ver Acta
                                    </a>
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="col-12 mb-3">
                                <label for="observaciones_edit" class="form-label">Observaciones (Opcional)</label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones_edit"
                                    name="observaciones" rows="2" placeholder="Añadir observaciones..."></textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5>2. Detalle de Productos</h5>
                        @error('detalles')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <!-- Buscador de Productos -->
                        <div class="row gx-2 mb-3">
                            <div class="col-md-7">
                                <label for="producto_search_edit" class="form-label">Buscar Producto (por Código o
                                    Nombre)</label>
                                <div class="search-results-wrapper">
                                    {{-- CAMBIO: Añadido input-group --}}
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="producto_search_edit"
                                            placeholder="Escriba para buscar productos...">
                                        <button class="btn btn-outline-secondary" type="button" id="btn_search_edit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    <div class="search-results" id="search_results_edit">
                                        <!-- Los resultados de AJAX se insertarán aquí -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#modalNuevoProductoRapido">
                                    <i class="bi bi-plus-circle"></i> Agregar Producto No Encontrado
                                </button>
                            </div>
                        </div>

                        <!-- Tabla de Productos Seleccionados -->
                        <div class="table-responsive">
                            <table class="table table-bordered tabla-detalles">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50%;">Producto</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio Unit. (S/)</th>
                                        <th scope="col" class="text-center">Quitar</th>
                                    </tr>
                                </thead>
                                <tbody id="detalle_table_body_edit">
                                    <!-- Filas de detalles existentes se cargan con JS aquí -->
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Préstamo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Editar Préstamo -->


    <!-- INICIO: Modal para VER Detalles -->
    <div class="modal fade" id="modalVerDetalles" tabindex="-1" aria-labelledby="modalVerDetallesLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerDetallesLabel">Detalles del Préstamo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="prestamo_info_header"></p>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col" class="text-end">Cantidad</th>
                                    <th scope="col" class="text-end">Precio Unit.</th>
                                    <th scope="col" class="text-end">Subtotal</th>
                                    <th scope="col">Usuario Reg.</th>
                                </tr>
                            </thead>
                            <tbody id="tabla_detalles_vista">
                                <!-- Contenido se carga vía JS -->
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th id="total_detalles_vista" class="text-end">S/ 0.00</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para VER Detalles -->


    <!-- INICIO: Modal para Nuevo Producto RÁPIDO (Modal-en-Modal) -->
    <div class="modal fade" id="modalNuevoProductoRapido" tabindex="-1"
        aria-labelledby="modalNuevoProductoRapidoLabel" aria-hidden="true" style="z-index: 1056;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoProductoRapidoLabel">Agregar Producto Rápido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Creación Rápida -->
                <form id="formProductoRapido">
                    {{-- No necesita @csrf porque lo enviaremos con el token JS --}}
                    <div class="modal-body">
                        <div id="errors_producto_rapido" class="alert alert-danger" style="display: none;"></div>

                        <div class="mb-3">
                            <label for="codigo_rapido" class="form-label">Código (*)</label>
                            <input type="text" class="form-control" id="codigo_rapido" name="codigo" required
                                placeholder="Código único">
                            <div class="invalid-feedback" id="error_codigo_rapido"></div>
                        </div>
                        <div class="mb-3">
                            <label for="nombre_rapido" class="form-label">Nombre (*)</label>
                            <input type="text" class="form-control" id="nombre_rapido" name="nombre" required
                                placeholder="Nombre descriptivo del producto">
                            <div class="invalid-feedback" id="error_nombre_rapido"></div>
                        </div>
                        <div class="mb-3">
                            <label for="uni_medida_rapido" class="form-label">Unidad de Medida</label>
                            <input type="text" class="form-control" id="uni_medida_rapido" name="uni_medida"
                                placeholder="Ej: UND, M2, GLB">
                            <div class="invalid-feedback" id="error_uni_medida_rapido"></div>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_rapido" class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="tipo_rapido" name="tipo"
                                placeholder="Ej: Herramienta, Material, EPP">
                            <div class="invalid-feedback" id="error_tipo_rapido"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnGuardarProductoRapido">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                style="display: none;"></span>
                            Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Nuevo Producto RÁPIDO -->

@endsection

{{-- INICIO: Scripts de la página --}}
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- CAMBIO: Se reemplazó la URL rota de debounce por la biblioteca Lodash --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>

    <script>
        // --- URLs y Tokens Globales para JS ---
        const buscarProductoUrl = '{{ route('productos.buscar') }}';
        const storeProductoRapidoUrl = '{{ route('productos.storeRapido') }}';
        const csrfToken = '{{ csrf_token() }}';
        const placeholderSinFoto = 'https://placehold.co/60x60/eee/ccc?text=Sin+Foto';

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
                    const prestamoData = JSON.parse(this.getAttribute('data-prestamo'));
                    const updateUrl = this.getAttribute('data-update-url');
                    const actaUrl = this.getAttribute('data-acta-url');
                    const detailsUrl = this.getAttribute('data-details-url');

                    const form = document.getElementById('editForm');
                    form.setAttribute('action', updateUrl);

                    // --- Rellenar Maestro ---
                    if (document.getElementById('almacen_id_edit')) { // Admin
                        document.getElementById('almacen_id_edit').value = prestamoData.almacen_id;
                    } else if (document.getElementById('almacen_id_edit_hidden')) { // Usuario normal
                        document.getElementById('almacen_id_edit_hidden').value = prestamoData
                            .almacen_id;
                    }
                    document.getElementById('obra_id_edit').value = prestamoData.obra_id;

                    // --- CORRECCIÓN PARA FECHAS ---
                    // El input type="date" requiere el formato YYYY-MM-DD.
                    // El JSON de Laravel (data-prestamo) lo envía como un timestamp ISO (ej: 2025-11-16T00:00:00Z).
                    // Usamos .split('T')[0] para obtener solo la parte de la fecha.

                    // Corregir fecha_prestamo
                    if (prestamoData.fecha_prestamo) {
                        document.getElementById('fecha_prestamo_edit').value = prestamoData.fecha_prestamo.split('T')[0];
                    } else {
                        document.getElementById('fecha_prestamo_edit').value = ''; // Opcional: limpiar si es nulo
                    }

                    // Corregir fecha_devolucion
                    if (prestamoData.fecha_devolucion) {
                        document.getElementById('fecha_devolucion_edit').value = prestamoData.fecha_devolucion.split('T')[0];
                    } else {
                        document.getElementById('fecha_devolucion_edit').value = ''; // Asegurarse de que esté vacío si es nulo
                    }
                    // --- FIN DE LA CORRECCIÓN ---

                    document.getElementById('tipo_prestamo_edit').value = prestamoData.tipo_prestamo;
                    document.getElementById('estado_edit').value = prestamoData.estado;
                    document.getElementById('numero_acta_edit').value = prestamoData.numero_acta;
                    document.getElementById('observaciones_edit').value = prestamoData.observaciones;
                    document.getElementById('acta_edit').value = null; // Limpiar file input

                    // Mostrar acta actual
                    const actaWrapper = document.getElementById('acta_actual_wrapper_edit');
                    const actaLink = document.getElementById('acta_actual_link_edit');
                    if (actaUrl) {
                        actaLink.href = actaUrl;
                        actaWrapper.style.display = 'block';
                    } else {
                        actaWrapper.style.display = 'none';
                    }

                    // --- Rellenar Detalles (vía AJAX) ---
                    const tbody = document.getElementById('detalle_table_body_edit');
                    tbody.innerHTML =
                        '<tr><td colspan="4" class="text-center"><div class="spinner-border spinner-border-sm" role="status"></div></td></tr>';

                    fetch(detailsUrl)
                        .then(response => response.json())
                        .then(detalles => {
                            tbody.innerHTML = ''; // Limpiar loader
                            detalles.forEach(detalle => {
                                // Usar la función global para añadir la fila
                                // (El producto viene anidado)
                                agregarFilaDetalle(detalle.producto, 'edit', detalle.cantidad,
                                    detalle.precio_unitario);
                            });
                        })
                        .catch(error => {
                            console.error('Error cargando detalles:', error);
                            tbody.innerHTML =
                                '<tr><td colspan="4" class="text-danger">Error al cargar los detalles.</td></tr>';
                        });
                });
            });


            // --- 5. LÓGICA DEL BUSCADOR DE PRODUCTOS (para modal "Nuevo") ---
            const searchInputNew = document.getElementById('producto_search_new');
            const searchButtonNew = document.getElementById('btn_search_new'); // <-- Botón añadido
            const searchResultsNew = document.getElementById('search_results_new');
            const detalleTbodyNew = document.getElementById('detalle_table_body_new');

            // Prevenir "Enter" en el input de búsqueda y ejecutar búsqueda
            searchInputNew.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    ejecutarBusqueda('new'); // Ejecuta la búsqueda inmediatamente
                }
            });

            // Buscar al hacer clic en el botón
            searchButtonNew.addEventListener('click', function() {
                ejecutarBusqueda('new'); // Ejecuta la búsqueda inmediatamente
            });

            // Usamos debounce para no sobrecargar el servidor AL ESCRIBIR
            // CAMBIO: Se usa _.debounce de la biblioteca Lodash
            const debouncedSearchNew = _.debounce(function() {
                ejecutarBusqueda('new');
            }, 300); // 300ms de espera

            searchInputNew.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    return; // Ya manejado por keydown
                }
                const term = searchInputNew.value;
                if (term.length < 2) {
                    searchResultsNew.style.display = 'none';
                    return;
                }
                debouncedSearchNew(); // Llamar a la función debounced
            });


            // --- 6. LÓGICA DEL BUSCADOR DE PRODUCTOS (para modal "Editar") ---
            const searchInputEdit = document.getElementById('producto_search_edit');
            const searchButtonEdit = document.getElementById('btn_search_edit'); // <-- Botón añadido
            const searchResultsEdit = document.getElementById('search_results_edit');
            const detalleTbodyEdit = document.getElementById('detalle_table_body_edit');

            // Prevenir "Enter" en el input de búsqueda y ejecutar búsqueda
            searchInputEdit.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    ejecutarBusqueda('edit'); // Ejecuta la búsqueda inmediatamente
                }
            });

            // Buscar al hacer clic en el botón
            searchButtonEdit.addEventListener('click', function() {
                ejecutarBusqueda('edit'); // Ejecuta la búsqueda inmediatamente
            });

            // Usamos debounce para no sobrecargar el servidor AL ESCRIBIR
            // CAMBIO: Se usa _.debounce de la biblioteca Lodash
            const debouncedSearchEdit = _.debounce(function() {
                ejecutarBusqueda('edit');
            }, 300); // 300ms de espera

            searchInputEdit.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    return; // Ya manejado por keydown
                }
                const term = searchInputEdit.value;
                if (term.length < 2) {
                    searchResultsEdit.style.display = 'none';
                    return;
                }
                debouncedSearchEdit(); // Llamar a la función debounced
            });


            // --- 7. LÓGICA para MODAL "VER DETALLES" ---
            const modalVerDetalles = document.getElementById('modalVerDetalles');
            modalVerDetalles.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const detailsUrl = button.getAttribute('data-details-url');
                const prestamoInfo = button.getAttribute('data-prestamo-info');

                document.getElementById('prestamo_info_header').textContent = prestamoInfo;
                const tbody = document.getElementById('tabla_detalles_vista');
                const tfootTotal = document.getElementById('total_detalles_vista');
                tbody.innerHTML =
                    '<tr><td colspan="5" class="text-center"><div class="spinner-border text-primary" role="status"></div></td></tr>';
                tfootTotal.textContent = 'S/ 0.00';
                let totalGeneral = 0;

                fetch(detailsUrl)
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la respuesta de red');
                        return response.json();
                    })
                    .then(detalles => {
                        tbody.innerHTML = ''; // Limpiar loader
                        if (detalles.length === 0) {
                            tbody.innerHTML =
                                '<tr><td colspan="5" class="text-center text-muted">Este préstamo no tiene productos registrados.</td></tr>';
                            return;
                        }

                        detalles.forEach(detalle => {
                            const subtotal = (detalle.cantidad || 0) * (detalle.precio_unitario || 0);
                            totalGeneral += subtotal;

                            // --- CORRECCIÓN: Añadir comprobaciones de nulos ---
                            const productoNombre = detalle.producto ? detalle.producto.nombre : '<span class="text-danger">Producto no encontrado</span>';
                            const productoCodigo = detalle.producto ? detalle.producto.codigo : 'N/A';
                            // Combinamos nombre y apellido del usuario
                            const usuarioNombre = detalle.user ? `${detalle.user.nombres} ${detalle.user.apellidos}` : '<span class="text-muted">N/A</span>';
                            
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>
                                    <span class="detalle-producto-nombre">${productoNombre}</span>
                                    <span class="detalle-producto-codigo">Código: ${productoCodigo}</span>
                                </td>
                                <td class="text-end">${parseFloat(detalle.cantidad).toFixed(2)}</td>
                                <td class="text-end">S/ ${parseFloat(detalle.precio_unitario).toFixed(2)}</td>
                                <td class="text-end">S/ ${subtotal.toFixed(2)}</td>
                                <td>${usuarioNombre}</td>
                            `;
                            tbody.appendChild(tr);
                        });

                        tfootTotal.textContent = `S/ ${totalGeneral.toFixed(2)}`;
                    })
                    .catch(error => {
                        console.error('Error cargando detalles para ver:', error);
                        tbody.innerHTML =
                            '<tr><td colspan="5" class="text-center text-danger">Error al cargar los detalles.</td></tr>';
                    });
            });


            // --- 8. LÓGICA para MODAL "PRODUCTO RÁPIDO" ---
            const formProductoRapido = document.getElementById('formProductoRapido');
            const modalProductoRapido = new bootstrap.Modal(document.getElementById('modalNuevoProductoRapido'));

            formProductoRapido.addEventListener('submit', function(event) {
                event.preventDefault();
                const btnSubmit = document.getElementById('btnGuardarProductoRapido');
                const spinner = btnSubmit.querySelector('.spinner-border');

                // Mostrar loader y deshabilitar botón
                btnSubmit.disabled = true;
                spinner.style.display = 'inline-block';

                // Limpiar errores antiguos
                limpiarErroresRapido();

                const formData = new FormData(formProductoRapido);

                fetch(storeProductoRapidoUrl, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw data;
                            }); // Lanzar error si no es 2xx
                        }
                        return response.json(); // Continuar si es 2xx
                    })
                    .then(producto => {
                        // Éxito: Añadir producto a la tabla de detalles activa

                        // Determinar qué modal está activo (Nuevo o Editar)
                        const modalActivo = document.getElementById('modalNuevoPrestamo').classList.contains(
                            'show') ? 'new' : 'edit';

                        agregarFilaDetalle(producto, modalActivo, 1, 0); // Añadir con cant 1 y precio 0

                        // Cerrar modal rápido y limpiar formulario
                        modalProductoRapido.hide();
                        formProductoRapido.reset();

                        Swal.fire({
                            icon: 'success',
                            title: 'Producto Creado',
                            text: `"${producto.nombre}" se agregó al préstamo.`,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    })
                    .catch(errorData => {
                        // Manejar errores (validación u otros)
                        if (errorData.errors) {
                            mostrarErroresRapido(errorData.errors);
                        } else {
                            document.getElementById('errors_producto_rapido').textContent =
                                'Error inesperado. Intente de nuevo.';
                            document.getElementById('errors_producto_rapido').style.display = 'block';
                        }
                    })
                    .finally(() => {
                        // Ocultar loader y habilitar botón
                        btnSubmit.disabled = false;
                        spinner.style.display = 'none';
                    });
            });
        });


        // --- FUNCIONES AUXILIARES GLOBALES ---

        /**
         * Ejecuta la búsqueda de productos y muestra los resultados.
         */
        function ejecutarBusqueda(modalType) {
            const term = document.getElementById(`producto_search_${modalType}`).value;
            const resultsContainer = document.getElementById(`search_results_${modalType}`);

            if (term.length < 2) {
                resultsContainer.innerHTML =
                    '<div class="p-2 text-muted text-center">Escriba al menos 2 caracteres.</div>';
                resultsContainer.style.display = 'block';
                return;
            }

            fetch(`${buscarProductoUrl}?term=${term}`)
                .then(response => response.json())
                .then(productos => {
                    mostrarResultadosBusqueda(productos, modalType);
                })
                .catch(error => {
                    console.error('Error en la búsqueda:', error);
                    resultsContainer.innerHTML =
                        '<div class="p-2 text-danger text-center">Error al buscar.</div>';
                    resultsContainer.style.display = 'block';
                });
        }

        /**
         * Muestra los resultados de la búsqueda de productos en el DOM.
         */
        function mostrarResultadosBusqueda(productos, modalType) {
            const resultsContainer = document.getElementById(`search_results_${modalType}`);
            resultsContainer.innerHTML = ''; // Limpiar resultados anteriores

            if (productos.length === 0) {
                resultsContainer.innerHTML = '<div class="p-2 text-muted text-center">No se encontraron productos.</div>';
                resultsContainer.style.display = 'block';
                return;
            }

            productos.forEach(producto => {
                const item = document.createElement('div');
                item.className = 'search-result-item';
                item.innerHTML = `
                    <img src="${producto.foto_url || placeholderSinFoto}" alt="${producto.nombre}">
                    <div class="search-result-info">
                        <strong>${producto.nombre}</strong>
                        <small>Código: ${producto.codigo} (${producto.uni_medida || 'N/A'})</small>
                    </div>
                `;
                // Añadir evento click para seleccionar el producto
                item.addEventListener('click', () => {
                    agregarFilaDetalle(producto, modalType);
                    resultsContainer.style.display = 'none'; // Ocultar resultados
                    document.getElementById(`producto_search_${modalType}`).value = ''; // Limpiar buscador
                });
                resultsContainer.appendChild(item);
            });

            resultsContainer.style.display = 'block'; // Mostrar resultados
        }

        /**
         * Añade una fila de producto a la tabla de detalles.
         * producto: Objeto del producto (desde AJAX o carga inicial)
         * modalType: 'new' o 'edit'
         * cantidad: Cantidad (para precargar en modal edit)
         * precio: Precio (para precargar en modal edit)
         */
        function agregarFilaDetalle(producto, modalType, cantidad = 1, precio = 0.00) {
            const tbody = document.getElementById(`detalle_table_body_${modalType}`);

            // --- Evitar duplicados ---
            const inputsExistentes = tbody.querySelectorAll('input[name$="[producto_id]"]');
            let yaExiste = false;
            inputsExistentes.forEach(input => {
                if (input.value == producto.id) {
                    yaExiste = true;
                }
            });

            if (yaExiste) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Producto ya agregado',
                    text: `"${producto.nombre}" ya está en la lista.`,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                return; // No agregar si ya existe
            }

            // --- Crear la nueva fila ---
            const tr = document.createElement('tr');
            const rowIndex = tbody.rows.length; // Índice para el array del formulario

            tr.innerHTML = `
                <td>
                    <span class="detalle-producto-nombre">${producto.nombre}</span>
                    <span class="detalle-producto-codigo">Código: ${producto.codigo}</span>
                    <input type="hidden" name="detalles[${rowIndex}][producto_id]" value="${producto.id}">
                </td>
                <td>
                    <input type="number" class="form-control" name="detalles[${rowIndex}][cantidad]" 
                           step="0.01" min="0.01" value="${cantidad}" required placeholder="Ej: 10.5">
                </td>
                <td>
                    <input type="number" class="form-control" name="detalles[${rowIndex}][precio_unitario]" 
                           step="0.01" min="0" value="${parseFloat(precio).toFixed(2)}" required placeholder="Ej: 50.00">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-remove-detalle">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </td>
            `;

            // Añadir evento de eliminación a la nueva fila
            tr.querySelector('.btn-remove-detalle').addEventListener('click', function() {
                tr.remove(); // Eliminar la fila
                reindexarTablaDetalles(tbody); // Re-indexar las filas restantes
            });

            tbody.appendChild(tr);
        }

        /**
         * Re-indexa los nombres de los inputs (ej. detalles[2][...]) cuando se elimina una fila.
         */
        function reindexarTablaDetalles(tbody) {
            const filas = tbody.querySelectorAll('tr');
            filas.forEach((fila, index) => {
                fila.querySelectorAll('input').forEach(input => {
                    // Actualizar el índice en el nombre: detalles[indice][campo]
                    if (input.name) {
                        input.name = input.name.replace(/detalles\[\d+\]/, `detalles[${index}]`);
                    }
                });
            });
        }

        /**
         * Muestra los errores de validación en el modal de producto rápido.
         */
        function mostrarErroresRapido(errors) {
            limpiarErroresRapido();
            const errorList = document.getElementById('errors_producto_rapido');
            let errorHtml = '<ul>';

            for (const key in errors) {
                const input = document.getElementById(`${key}_rapido`);
                const errorField = document.getElementById(`error_${key}_rapido`);

                if (input && errorField) {
                    input.classList.add('is-invalid');
                    errorField.textContent = errors[key][0];
                } else {
                    errorHtml += `<li>${errors[key][0]}</li>`;
                }
            }

            if (errorHtml !== '<ul>') {
                errorList.innerHTML = errorHtml + '</ul>';
                errorList.style.display = 'block';
            }
        }

        /**
         * Limpia los errores de validación del modal de producto rápido.
         */
        function limpiarErroresRapido() {
            document.getElementById('errors_producto_rapido').style.display = 'none';
            document.getElementById('errors_producto_rapido').innerHTML = '';

            document.getElementById('codigo_rapido').classList.remove('is-invalid');
            document.getElementById('nombre_rapido').classList.remove('is-invalid');
            document.getElementById('uni_medida_rapido').classList.remove('is-invalid');
            document.getElementById('tipo_rapido').classList.remove('is-invalid');

            document.getElementById('error_codigo_rapido').textContent = '';
            document.getElementById('error_nombre_rapido').textContent = '';
            document.getElementById('error_uni_medida_rapido').textContent = '';
            document.getElementById('error_tipo_rapido').textContent = '';
        }
    </script>
@endsection
{{-- FIN: Scripts de la página --}}