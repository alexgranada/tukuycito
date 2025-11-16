@extends('plantillas.app')
@section('titulo', 'Tukuycito - Panel Fotográfico')
@section('nombre', 'Gestión de Paneles Fotográficos')

@section('css')
    {{-- CSS para el visor de imágenes (si se desea) --}}
    <style>
        /* Estilos para que las imágenes en el modal sean responsivas */
        .img-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }

        .img-gallery img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .img-gallery img:hover {
            transform: scale(1.05);
        }

        /* Contenedor de foto en modal de edición */
        .foto-edit-container {
            position: relative;
            margin-bottom: 10px;
        }

        .foto-edit-container img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .btn-delete-foto {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 10;
        }
    </style>
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
            <form action="{{ route('paneles-fotograficos.index') }}" method="GET">
                <div class="row gx-3">

                    <div class="col-md-3 mb-3">
                        <label for="n_guia" class="form-label">N° Guía</label>
                        <input type="text" class="form-control" id="n_guia" name="n_guia"
                            value="{{ request('n_guia') }}" placeholder="Buscar por Guía...">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa"
                            value="{{ request('placa') }}" placeholder="Buscar por Placa...">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="oc" class="form-label">O/C</label>
                        <input type="text" class="form-control" id="oc" name="oc"
                            value="{{ request('oc') }}" placeholder="Buscar por O/C...">
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        <a href="{{ route('paneles-fotograficos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIN: Formulario de Búsqueda -->


    <!-- INICIO: Tarjeta de Tabla de Paneles -->
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Lista de Paneles Registrados</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalNuevoPanel">
                        <i class="bi bi-plus-lg me-1"></i>
                        Registrar Nuevo Panel
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">N° Guía</th>
                                    <th scope="col">Placa</th>
                                    <th scope="col">O/C</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col" class="text-center">Fotos</th>
                                    <th scope="col" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($paneles as $panel)
                                    <tr>
                                        <td>{{ $panel->fecha }}</td>
                                        <td>{{ $panel->n_guia ?? 'N/A' }}</td>
                                        <td>{{ $panel->placa ?? 'N/A' }}</td>
                                        <td>{{ $panel->oc ?? 'N/A' }}</td>
                                        <td>{{ $panel->producto->nombre ?? 'N/A' }}</td>
                                        <td>{{ $panel->usuario->nombres ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $panel->fotos_count ?? $panel->fotos->count() }}</span>
                                        </td>
                                        <td class="text-center">
                                            <!-- Botón Ver Fotos -->
                                            <button type="button" class="btn btn-success btn-md btn-view" title="Ver Fotos"
                                                data-bs-toggle="modal" data-bs-target="#modalVerFotos"
                                                data-fotos-url="{{ route('paneles.getFotos', $panel) }}">
                                                <i class="bi bi-images"></i>
                                            </button>

                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-info btn-md btn-edit" title="Editar"
                                                data-bs-toggle="modal" data-bs-target="#modalEditPanel-{{ $panel->id }}"
                                                data-panel="{{ $panel->toJson() }}"
                                                data-update-url="{{ route('paneles-fotograficos.update', $panel) }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <button type="button" class="btn btn-danger btn-md btn-delete" title="Eliminar"
                                                data-delete-url="{{ route('paneles-fotograficos.destroy', $panel) }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No se encontraron paneles fotográficos.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $paneles->links('vendor.pagination.paginacion') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Tarjeta de Tabla de Paneles -->


    <!-- Formulario oculto para Eliminar (se usa con JS) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>


    <!-- INICIO: Modal para Nuevo Panel -->
    <div class="modal fade" id="modalNuevoPanel" tabindex="-1" aria-labelledby="modalNuevoPanelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoPanelLabel">Registrar Nuevo Panel Fotográfico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Formulario de Creación -->
                {{-- Importante: enctype para subir archivos --}}
                <form action="{{ route('paneles-fotograficos.store') }}" method="POST" enctype="multipart/form-data" id="formNuevoPanel">
                    @csrf
                    <div class="modal-body">
                        <div class="row gx-3">

                            <div class="col-md-6 mb-3">
                                <label for="fecha_new" class="form-label">Fecha (*)</label>
                                <input type="date" class="form-control @error('fecha', 'create_panel') is-invalid @enderror"
                                    id="fecha_new" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required>
                                @error('fecha', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="producto_id_new" class="form-label">Producto (Opcional)</label>
                                <select class="form-select @error('producto_id', 'create_panel') is-invalid @enderror" id="producto_id_new" name="producto_id">
                                    <option value="">-- Seleccione un producto --</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                            {{ $producto->nombre }} ({{ $producto->codigo }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('producto_id', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="n_guia_new" class="form-label">N° Guía</label>
                                <input type="text" class="form-control @error('n_guia', 'create_panel') is-invalid @enderror"
                                    id="n_guia_new" name="n_guia" value="{{ old('n_guia') }}" placeholder="N° de Guía">
                                @error('n_guia', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="placa_new" class="form-label">Placa</label>
                                <input type="text" class="form-control @error('placa', 'create_panel') is-invalid @enderror"
                                    id="placa_new" name="placa" value="{{ old('placa') }}" placeholder="Placa Vehículo">
                                @error('placa', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="precinto_new" class="form-label">Precinto</label>
                                <input type="text" class="form-control @error('precinto', 'create_panel') is-invalid @enderror"
                                    id="precinto_new" name="precinto" value="{{ old('precinto') }}" placeholder="Precinto">
                                @error('precinto', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="oc_new" class="form-label">O/C</label>
                                <input type="text" class="form-control @error('oc', 'create_panel') is-invalid @enderror"
                                    id="oc_new" name="oc" value="{{ old('oc') }}" placeholder="Orden de Compra">
                                @error('oc', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tipo_new" class="form-label">Tipo</label>
                                <input type="text" class="form-control @error('tipo', 'create_panel') is-invalid @enderror"
                                    id="tipo_new" name="tipo" value="{{ old('tipo') }}" placeholder="Ej: Ingreso, Salida">
                                @error('tipo', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="ubicacion_new" class="form-label">Ubicación</label>
                                <input type="text" class="form-control @error('ubicacion', 'create_panel') is-invalid @enderror"
                                    id="ubicacion_new" name="ubicacion" value="{{ old('ubicacion') }}" placeholder="Ubicación/Destino">
                                @error('ubicacion', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="observaciones_new" class="form-label">Observaciones</label>
                                <textarea class="form-control @error('observaciones', 'create_panel') is-invalid @enderror"
                                    id="observaciones_new" name="observaciones" rows="2">{{ old('observaciones') }}</textarea>
                                @error('observaciones', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <hr>

                            <div class="col-12 mb-3">
                                <label for="fotos_new" class="form-label">Fotos (Máx. 4) (*)</label>
                                <input type="file" class="form-control @error('fotos', 'create_panel') is-invalid @enderror @error('fotos.*', 'create_panel') is-invalid @enderror" 
                                    id="fotos_new" name="fotos[]" multiple accept="image/*">
                                <small id="fotos_new_help" class="form-text text-muted">Seleccione hasta 4 imágenes.</small>
                                
                                @error('fotos', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('fotos.*', 'create_panel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Panel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Nuevo Panel -->


    <!-- INICIO: Modales para Editar Panel (Generados dinámicamente) -->
    @foreach ($paneles as $panel)
        <div class="modal fade" id="modalEditPanel-{{ $panel->id }}" tabindex="-1" aria-labelledby="modalEditPanelLabel-{{ $panel->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditPanelLabel-{{ $panel->id }}">Editar Panel Fotográfico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Formulario de Edición -->
                    <form action="{{ route('paneles-fotograficos.update', $panel) }}" method="POST" enctype="multipart/form-data" class="formEditPanel">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row gx-3">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fecha (*)</label>
                                    <input type="date" class="form-control" name="fecha" value="{{ old('fecha', $panel->fecha) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Producto (Opcional)</label>
                                    <select class="form-select" name="producto_id">
                                        <option value="">-- Seleccione un producto --</option>
                                        @foreach($productos as $producto)
                                            <option value="{{ $producto->id }}" {{ (old('producto_id') ?? $panel->producto_id) == $producto->id ? 'selected' : '' }}>
                                                {{ $producto->nombre }} ({{ $producto->codigo }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">N° Guía</label>
                                    <input type="text" class="form-control" name="n_guia" value="{{ old('n_guia', $panel->n_guia) }}" placeholder="N° de Guía">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Placa</label>
                                    <input type="text" class="form-control" name="placa" value="{{ old('placa', $panel->placa) }}" placeholder="Placa Vehículo">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Precinto</label>
                                    <input type="text" class="form-control" name="precinto" value="{{ old('precinto', $panel->precinto) }}" placeholder="Precinto">
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">O/C</label>
                                    <input type="text" class="form-control" name="oc" value="{{ old('oc', $panel->oc) }}" placeholder="Orden de Compra">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipo</label>
                                    <input type="text" class="form-control" name="tipo" value="{{ old('tipo', $panel->tipo) }}" placeholder="Ej: Ingreso, Salida">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Ubicación</label>
                                    <input type="text" class="form-control" name="ubicacion" value="{{ old('ubicacion', $panel->ubicacion) }}" placeholder="Ubicación/Destino">
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label class="form-label">Observaciones</label>
                                    <textarea class="form-control" name="observaciones" rows="2">{{ old('observaciones', $panel->observaciones) }}</textarea>
                                </div>
                                
                                <hr>

                                <!-- Sección de Fotos -->
                                <div class="col-12">
                                    <h5>Fotos Actuales</h5>
                                    <div class="row" id="fotos-actuales-{{ $panel->id }}">
                                        @if($panel->fotos->isEmpty())
                                            <p class="text-muted">No hay fotos actuales.</p>
                                        @else
                                            @foreach($panel->fotos as $foto)
                                                <div class="col-md-3 col-6 foto-edit-container" id="foto-container-{{ $foto->id }}">
                                                    <img src="{{ Storage::disk('public')->url($foto->foto) }}" alt="Foto" class="img-thumbnail">
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete-foto" data-foto-id="{{ $foto->id }}" data-delete-url="{{ route('paneles.fotos.destroy', $foto) }}" title="Eliminar Foto">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mb-3 mt-3">
                                    <label class="form-label">Añadir Nuevas Fotos (Límite 4 en total)</label>
                                    <input type="file" class="form-control" name="fotos_nuevas[]" multiple accept="image/*" data-panel-id="{{ $panel->id }}">
                                    <small class="form-text text-muted">Solo puedes añadir más si el total es 4 o menos.</small>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Actualizar Panel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- FIN: Modales para Editar Panel -->


    <!-- INICIO: Modal para Ver Fotos -->
    <div class="modal fade" id="modalVerFotos" tabindex="-1" aria-labelledby="modalVerFotosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalVerFotosLabel">Fotos del Panel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="loadingSpinner" class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                    <div id="galeriaFotos" class="img-gallery" style="display: none;">
                        {{-- Las fotos se cargarán aquí vía JS --}}
                    </div>
                    <p id="noFotos" class="text-center text-muted" style="display: none;">No hay fotos para este panel.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN: Modal para Ver Fotos -->

@endsection

{{-- INICIO: Scripts de la página --}}
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}';

            // --- 1. ALERTA DE ÉXITO/ERROR (SweetAlert2) ---
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


            // --- 2. Lógica para Botones de ELIMINAR (Panel) ---
            const deleteForm = document.getElementById('deleteForm');
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const deleteUrl = this.getAttribute('data-delete-url');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esta acción! Se eliminará el panel y todas sus fotos asociadas.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, ¡eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteForm.setAttribute('action', deleteUrl);
                            deleteForm.submit();
                        }
                    });
                });
            });


            // --- 3. Lógica para MODAL VER FOTOS ---
            const modalVerFotos = document.getElementById('modalVerFotos');
            const galeriaFotos = document.getElementById('galeriaFotos');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const noFotos = document.getElementById('noFotos');

            modalVerFotos.addEventListener('show.bs.modal', async function(event) {
                // Resetear estado
                galeriaFotos.innerHTML = '';
                galeriaFotos.style.display = 'none';
                noFotos.style.display = 'none';
                loadingSpinner.style.display = 'block';

                const button = event.relatedTarget;
                const fotosUrl = button.getAttribute('data-fotos-url');

                try {
                    const response = await fetch(fotosUrl);
                    if (!response.ok) {
                        throw new Error('Error al cargar las fotos.');
                    }
                    const fotos = await response.json();

                    loadingSpinner.style.display = 'none';

                    if (fotos.length > 0) {
                        fotos.forEach(foto => {
                            const img = document.createElement('img');
                            img.src = foto.url; // 'url' fue añadida en el controlador
                            img.alt = foto.descripcion || 'Foto del panel';
                            img.className = 'img-thumbnail';
                            // Opcional: Abrir en pestaña nueva al hacer clic
                            img.onclick = () => window.open(foto.url, '_blank');
                            galeriaFotos.appendChild(img);
                        });
                        galeriaFotos.style.display = 'grid'; // Cambiado a grid
                    } else {
                        noFotos.style.display = 'block';
                    }
                } catch (error) {
                    console.error(error);
                    loadingSpinner.style.display = 'none';
                    galeriaFotos.innerHTML = '<p class="text-danger text-center">No se pudieron cargar las fotos.</p>';
                    galeriaFotos.style.display = 'block';
                }
            });


            // --- 4. MANEJO DE ERRORES de VALIDACIÓN DEL MODAL ---
            @if (session('open_modal'))
                var modalToOpen = new bootstrap.Modal(document.getElementById('{{ session('open_modal') }}'));
                modalToOpen.show();
            @endif
            
            // Re-abrir modal de edición si falla la validación
            @if ($errors->any())
                @php
                    $errorBagName = '';
                    foreach ($errors->getBags() as $bagName => $bag) {
                        if (str_starts_with($bagName, 'edit_panel_')) {
                            $errorBagName = $bagName;
                            break;
                        }
                    }
                @endphp

                @if ($errorBagName)
                    // Extraer el ID del panel del nombre del error bag
                    @php $panelId = str_replace('edit_panel_', '', $errorBagName); @endphp
                    var modalId = 'modalEditPanel-' + '{{ $panelId }}';
                    var modalEdit = document.getElementById(modalId);
                    if(modalEdit) {
                        var modalInstance = new bootstrap.Modal(modalEdit);
                        modalInstance.show();
                    }
                @elseif ($errors->hasBag('create_panel'))
                    var modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevoPanel'));
                    modalNuevo.show();
                @endif
            @endif


            // --- 5. LÍMITE DE FOTOS (CLIENT-SIDE) ---
            const inputFotosNuevas = document.getElementById('fotos_new');
            const helpTextFotosNuevas = document.getElementById('fotos_new_help');
            
            if(inputFotosNuevas) {
                inputFotosNuevas.addEventListener('change', function() {
                    if (this.files.length > 4) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Límite excedido',
                            text: 'Solo puedes seleccionar un máximo de 4 fotos.'
                        });
                        this.value = ''; // Limpiar la selección
                        helpTextFotosNuevas.textContent = 'Seleccione hasta 4 imágenes.';
                        helpTextFotosNuevas.classList.remove('text-danger');
                    } else {
                        helpTextFotosNuevas.textContent = `Has seleccionado ${this.files.length} de 4 fotos.`;
                        helpTextFotosNuevas.classList.add('text-success');
                    }
                });
            }

            // --- 6. ELIMINAR FOTO INDIVIDUAL (MODAL EDITAR) ---
            document.querySelectorAll('.btn-delete-foto').forEach(button => {
                button.addEventListener('click', async function(e) {
                    e.preventDefault();
                    const fotoId = this.getAttribute('data-foto-id');
                    const deleteUrl = this.getAttribute('data-delete-url');
                    const fotoContainer = document.getElementById(`foto-container-${fotoId}`);

                    const result = await Swal.fire({
                        title: '¿Eliminar esta foto?',
                        text: "Esta acción no se puede revertir.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Sí, eliminar'
                    });

                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            });
                            
                            const data = await response.json();

                            if (data.success) {
                                fotoContainer.remove(); // Eliminar el contenedor de la foto
                                Swal.fire('¡Eliminada!', data.message, 'success');
                                // Opcional: actualizar el contador de fotos si tienes uno
                            } else {
                                throw new Error(data.message || 'Error desconocido');
                            }
                        } catch (error) {
                            console.error(error);
                            Swal.fire('Error', 'No se pudo eliminar la foto: ' + error.message, 'error');
                        }
                    }
                });
            });

        });
    </script>
@endsection
{{-- FIN: Scripts de la página --}}