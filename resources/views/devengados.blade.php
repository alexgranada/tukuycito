@extends('plantillas.app')
@section('titulo', 'Tukuycito - Devengados')
@section('nombre', 'Devengados')
@section('css')
@section('contenido')

    <!-- INICIO: Tarjeta de Búsqueda Avanzada (Abierta por defecto) -->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-search me-2"></i> Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            {{-- El formulario usa GET para que los filtros se pasen por la URL --}}
            {{-- CORRECCIÓN: La ruta es 'devengados.index' --}}
            <form action="{{ route('devengados.index') }}" method="GET">
                <div class="row gx-3">

                    {{-- Campo Almacén (Solo para Admin) --}}
                    @if (Auth::user()->tipo == 'admin' && isset($almacenes))
                        <div class="col-md-4 mb-3">
                            <label for="almacen_id" class="form-label">Almacén</label>
                            <select class="form-select" id="almacen_id" name="almacen_id">
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

                    {{-- Campos de Fecha --}}
                    <div class="col-md-4 mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                            value="{{ request('fecha_inicio') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                            value="{{ request('fecha_fin') }}">
                    </div>

                    {{-- Campos de Texto --}}
                    <div class="col-md-3 mb-3">
                        <label for="oc" class="form-label">O/C</label>
                        <input type="text" class="form-control" id="oc" name="oc" value="{{ request('oc') }}"
                            placeholder="Buscar O/C...">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="siaf" class="form-label">SIAF</label>
                        <input type="text" class="form-control" id="siaf" name="siaf"
                            value="{{ request('siaf') }}" placeholder="Buscar SIAF...">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="proveedor" class="form-label">Proveedor</label>
                        <input type="text" class="form-control" id="proveedor" name="proveedor"
                            value="{{ request('proveedor') }}" placeholder="Buscar Proveedor...">
                    </div>

                    {{-- Campo Estado --}}
                    <div class="col-md-3 mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="">-- Todos los Estados --</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>
                                    {{ ucfirst($estado) }}
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
                        {{-- CORRECCIÓN: La ruta es 'devengados.index' --}}
                        <a href="{{ route('devengados.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIN: Formulario de Búsqueda Avanzada -->


    <!-- Row start -->
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">

                <!-- INICIO: Encabezado de la Tarjeta de Tabla -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lista de Devengados</h5>
                    <!-- CAMBIO: Se añaden atributos data-bs-toggle y data-bs-target para abrir el modal -->
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalNuevoDevengado">
                        <i class="bi bi-plus-lg me-1"></i>
                        Registrar Nuevo Devengado
                    </button>
                </div>
                <!-- FIN: Encabezado de la Tarjeta de Tabla -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th scope="col">Almacén</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">O/C</th>
                                    <th scope="col">SIAF</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col" class="text-end">Precio Total</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Usuario Ingresado</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($devengados as $devenga)
                                    <!-- CAMBIO: Añadida clase condicional para filas anuladas -->
                                    <tr class="{{ $devenga->estado == 'anulado' ? 'table-secondary text-muted' : '' }}">
                                        <td>{{ $devenga->almacen->nombre }}</td>
                                        <td>{{ \Carbon\Carbon::parse($devenga->fecha)->format('d/m/Y') }}</td>
                                        <td>{{ $devenga->oc }}</td>
                                        <td>{{ $devenga->siaf ?? 'Sin SIAF' }}</td>
                                        <td>{{ $devenga->descripcion ?? 'Sin Detalle' }}</td> {{-- Coincide con tu BD --}}

                                        <td class="text-end fw-bold">S/ {{ number_format($devenga->precio_total, 2) }}
                                        </td>

                                        <td>
                                            @if ($devenga->estado == 'pagado')
                                                <span class="badge bg-success">Pagado</span>
                                            @elseif($devenga->estado == 'pendiente')
                                                <span class="badge bg-warning text-dark text-white">Pendiente</span>
                                            @elseif($devenga->estado == 'anulado')
                                                <span class="badge bg-danger">Anulado</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($devenga->estado) }}</span>
                                            @endif
                                        </td>

                                        <td>{{ $devenga->proveedor ?? 'No Registrado.' }}</td>
                                        {{-- Asumiendo que la relación 'usuario' existe y no es nula --}}
                                        <td>{{ $devenga->usuario->apellidos . ', ' . $devenga->usuario->nombres }}</td>

                                        <!-- CAMBIO: Botones con lógica de permisos y JS -->
                                        <td class="text-center">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-info btn-md btn-edit" title="Editar"
                                                data-bs-toggle="modal" data-bs-target="#modalEditDevengado"
                                                data-devengado="{{ $devenga->toJson() }}"
                                                data-update-url="{{ route('devengados.update', $devenga) }}"
                                                data-user-id="{{ $devenga->usuario_id }}" {{-- CORRECCIÓN: usuario_id --}}
                                                {{ $devenga->estado == 'anulado' ? 'disabled' : '' }}>
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Botón Anular -->
                                            <button type="button" class="btn btn-danger btn-md btn-anular"
                                                title="Anular"
                                                data-anular-url="{{ route('devengados.anular', $devenga) }}"
                                                data-user-id="{{ $devenga->usuario_id }}" {{-- CORRECCIÓN: usuario_id --}}
                                                {{ $devenga->estado == 'anulado' ? 'disabled' : '' }}>
                                                <i class="bi bi-x-circle"></i> {{-- Icono cambiado --}}
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">
                                            No se encontraron devengados con los filtros seleccionados.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $devengados->links('vendor.pagination.paginacion') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Formulario oculto para Anular (se usa con JS) -->
    <form id="anularForm" method="POST" style="display: none;">
        @csrf
    </form>


    <!-- INICIO: Modal para Nuevo Devengado (Sin cambios) -->
    <div class="modal fade" id="modalNuevoDevengado" tabindex="-1" aria-labelledby="modalNuevoDevengadoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoDevengadoLabel">Registrar Nuevo Devengado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Creación -->
                <form action="{{ route('devengados.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row gx-3">

                            <!-- Lógica de Almacén (Admin vs Usuario) -->
                            <div class="col-md-6 mb-3">
                                <label for="almacen_id_modal" class="form-label">Almacén</label>
                                @if (Auth::user()->tipo == 'admin')
                                    <select class="form-select @error('almacen_id') is-invalid @enderror"
                                        id="almacen_id_modal" name="almacen_id" required>
                                        <option value="">-- Seleccione Almacén --</option>
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
                                    <select class="form-select" id="almacen_id_modal" name="almacen_id_disabled"
                                        disabled>
                                        <option value="{{ Auth::user()->almacen_id }}" selected>
                                            {{ Auth::user()->almacen->nombre }}</option>
                                    </select>
                                    <!-- Campo oculto que envía el ID -->
                                    <input type="hidden" name="almacen_id" value="{{ Auth::user()->almacen_id }}">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control @error('fecha') is-invalid @enderror"
                                    id="fecha" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="oc" class="form-label">O/C (Orden de Compra)</label>
                                <input type="text" class="form-control @error('oc') is-invalid @enderror"
                                    id="oc" name="oc" value="{{ old('oc') }}"
                                    placeholder="Ej: 001-2025" required>
                                @error('oc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="siaf" class="form-label">SIAF (Opcional)</label>
                                <input type="text" class="form-control @error('siaf') is-invalid @enderror"
                                    id="siaf" name="siaf" value="{{ old('siaf') }}" placeholder="Ej: 5480">
                                @error('siaf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="proveedor" class="form-label">Proveedor (Opcional)</label>
                                <input type="text" class="form-control @error('proveedor') is-invalid @enderror"
                                    id="proveedor" name="proveedor" value="{{ old('proveedor') }}"
                                    placeholder="Nombre del proveedor">
                                @error('proveedor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="precio_total" class="form-label">Precio Total</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('precio_total') is-invalid @enderror" id="precio_total"
                                    name="precio_total" value="{{ old('precio_total') }}" placeholder="Ej: 1500.50"
                                    required>
                                @error('precio_total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="estado_modal" class="form-label">Estado</label>
                                <select class="form-select @error('estado') is-invalid @enderror" id="estado_modal"
                                    name="estado" required>
                                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>
                                        Pendiente</option>
                                    <option value="pagado" {{ old('estado') == 'pagado' ? 'selected' : '' }}>Pagado
                                    </option>
                                    <option value="anulado" {{ old('estado') == 'anulado' ? 'selected' : '' }}>Anulado
                                    </option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="descripcion" class="form-label">Detalle</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                    rows="2" placeholder="Detalle del devengado..." required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="observaciones" class="form-label">Observaciones (Opcional)</label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones"
                                    rows="2" placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Devengado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Nuevo Devengado -->


    <!-- INICIO: Modal para Editar Devengado -->
    <div class="modal fade" id="modalEditDevengado" tabindex="-1" aria-labelledby="modalEditDevengadoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditDevengadoLabel">Editar Devengado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Edición -->
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row gx-3">

                            <!-- Lógica de Almacén (Admin vs Usuario) -->
                            <div class="col-md-6 mb-3">
                                <label for="almacen_id_edit" class="form-label">Almacén</label>
                                @if (Auth::user()->tipo == 'admin')
                                    <select class="form-select" id="almacen_id_edit" name="almacen_id" required>
                                        <option value="">-- Seleccione Almacén --</option>
                                        @foreach ($almacenes as $almacen)
                                            <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <!-- Usuario Normal: Ve su almacén, deshabilitado -->
                                    <select class="form-select" id="almacen_id_edit_disabled" disabled>
                                        <option value="{{ Auth::user()->almacen_id }}" selected>
                                            {{ Auth::user()->almacen->nombre }}</option>
                                    </select>
                                    <input type="hidden" id="almacen_id_edit_hidden" name="almacen_id"
                                        value="{{ Auth::user()->almacen_id }}">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_edit" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha_edit" name="fecha" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="oc_edit" class="form-label">O/C (Orden de Compra)</label>
                                <input type="text" class="form-control" id="oc_edit" name="oc"
                                    placeholder="Ej: 001-2025" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="siaf_edit" class="form-label">SIAF (Opcional)</label>
                                <input type="text" class="form-control" id="siaf_edit" name="siaf"
                                    placeholder="Ej: 5480">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="proveedor_edit" class="form-label">Proveedor (Opcional)</label>
                                <input type="text" class="form-control" id="proveedor_edit" name="proveedor"
                                    placeholder="Nombre del proveedor">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="precio_total_edit" class="form-label">Precio Total</label>
                                <input type="number" step="0.01" class="form-control" id="precio_total_edit"
                                    name="precio_total" placeholder="Ej: 1500.50" required>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="estado_edit" class="form-label">Estado</label>
                                <select class="form-select" id="estado_edit" name="estado" required>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="pagado">Pagado</option>
                                    <option value="anulado">Anulado</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="descripcion_edit" class="form-label">Detalle</label>
                                <textarea class="form-control" id="descripcion_edit" name="descripcion" rows="2"
                                    placeholder="Detalle del devengado..." required></textarea>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="observaciones_edit" class="form-label">Observaciones (Opcional)</label>
                                <textarea class="form-control" id="observaciones_edit" name="observaciones" rows="2"
                                    placeholder="Observaciones adicionales..."></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Devengado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Editar Devengado -->

@endsection

{{-- INICIO: Scripts de la página --}}
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- 1. ALERTA DE ÉXITO/ERROR ---
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

            // --- 2. LÓGICA DE PERMISOS (ELIMINADA) ---
            // const currentUserId = {{ Auth::id() }};
            // const currentUserType = '{{ Auth::user()->tipo }}';
            // const errorAlert = (action) => { ... };

            // --- Lógica para Botones de EDITAR ---
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function(event) {
                    
                    // --- COMPROBACIÓN DE PERMISOS ELIMINADA ---
                    // const devengadoUserId = this.getAttribute('data-user-id');
                    // if (currentUserType !== 'admin' && currentUserId != devengadoUserId) {
                    //     event.stopPropagation(); 
                    //     errorAlert('editar');
                    //     return; 
                    // }
                    // --- FIN DE ELIMINACIÓN ---

                    // Rellenar el modal de edición
                    const devengadoData = JSON.parse(this.getAttribute('data-devengado'));
                    const updateUrl = this.getAttribute('data-update-url');

                    const form = document.getElementById('editForm');
                    form.setAttribute('action', updateUrl);

                    // Rellenar campos
                    if (document.getElementById('almacen_id_edit')) { // Comprueba si el select de admin existe
                        document.getElementById('almacen_id_edit').value = devengadoData.almacen_id;
                    }
                    
                    document.getElementById('fecha_edit').value = devengadoData.fecha;
                    document.getElementById('oc_edit').value = devengadoData.oc;
                    document.getElementById('siaf_edit').value = devengadoData.siaf;
                    document.getElementById('proveedor_edit').value = devengadoData.proveedor;
                    document.getElementById('precio_total_edit').value = devengadoData.precio_total;
                    document.getElementById('estado_edit').value = devengadoData.estado;
                    document.getElementById('descripcion_edit').value = devengadoData.descripcion; // Coincide con tu BD
                    document.getElementById('observaciones_edit').value = devengadoData.observaciones;
                });
            });

            // --- Lógica para Botones de ANULAR ---
            const anularForm = document.getElementById('anularForm');
            document.querySelectorAll('.btn-anular').forEach(button => {
                button.addEventListener('click', function() {
                    
                    // --- COMPROBACIÓN DE PERMISOS ELIMINADA ---
                    // const devengadoUserId = this.getAttribute('data-user-id');
                    // if (currentUserType !== 'admin' && currentUserId != devengadoUserId) {
                    //     errorAlert('anular');
                    //     return; 
                    // }
                    // --- FIN DE ELIMINACIÓN ---

                    // Mostrar confirmación
                    const anularUrl = this.getAttribute('data-anular-url');
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción cambiará el estado a 'anulado'. No podrás revertirlo.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, anular registro',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Enviar el formulario oculto a la ruta de anulación
                            anularForm.setAttribute('action', anularUrl);
                            anularForm.submit();
                        }
                    });
                });
            });

            // --- 3. MANEJO DE ERRORES DE VALIDACIÓN DEL MODAL ---
            @if ($errors->any())
                // Si hay un error, comprobamos qué formulario fue
                @if (old('form_type') == 'create_devengado')
                    var modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevoDevengado'));
                    modalNuevo.show();
                @elseif (old('form_type') == 'edit_devengado')
                     var modalEdit = new bootstrap.Modal(document.getElementById('modalEditDevengado'));
                     modalEdit.show();
                @endif
            @endif

        });
    </script>

    {{-- Script para reabrir el modal de 'create' si falla la validación (Simplificado) --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Este script es un fallback. Si la validación falla (en CUALQUIER modal),
                // y no logramos identificar cuál fue, al menos reabrimos el de "Nuevo".
                @if (!$errors->has('form_type')) // Si no pudimos identificar el formulario
                    var modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevoDevengado'));
                    modalNuevo.show();
                @endif
            });
        </script>
    @endif
@endsection
{{-- FIN: Scripts de la página --}}