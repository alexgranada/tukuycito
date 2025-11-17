@extends('plantillas.app')
@section('titulo', 'Tukuycito - Reporte Fotográfico')
@section('nombre', 'Reporte de Paneles Fotográficos')

@section('css')
    <style>
        /* Estilos para que las imágenes en el modal sean responsivas */
        .img-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }
        .img-gallery img {
            width: 100%; height: auto; border-radius: 8px; cursor: pointer;
        }
    </style>
@endsection

@section('contenido')

    <!-- INICIO: Tarjeta de Búsqueda Avanzada -->
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-search me-2"></i> Filtros de Búsqueda Avanzada
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('reportes.fotografico') }}" method="GET">
                <div class="row gx-3">

                    <div class="col-md-3 mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                            value="{{ request('fecha_inicio') }}">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                            value="{{ request('fecha_fin') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="producto_id" class="form-label">Producto</label>
                        <select class="form-select" id="producto_id" name="producto_id">
                            <option value="">-- Todos los Productos --</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}" {{ request('producto_id') == $producto->id ? 'selected' : '' }}>
                                    {{ $producto->nombre }} ({{ $producto->codigo }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="n_guia" class="form-label">N° Guía</label>
                        <input type="text" class="form-control" id="n_guia" name="n_guia"
                            value="{{ request('n_guia') }}" placeholder="Buscar por Guía...">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa"
                            value="{{ request('placa') }}" placeholder="Buscar por Placa...">
                    </div>

                    <div class="col-md-4 mb-3">
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
                        <a href="{{ route('reportes.fotografico') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIN: Formulario de Búsqueda -->


    <!-- INICIO: Tarjeta de Tabla de Resultados -->
    <div class="row gx-3">
        <div class="col-xxl-12">
            <div class="card mb-3">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Resultados del Reporte</h5>
                    {{-- No hay botón de "Crear" en reportes --}}
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

                                            <!-- Botón Exportar PDF -->
                                            <a href="{{-- {{ route('paneles.pdf', $panel) }} --}}" class="btn btn-danger btn-md" 
                                               title="Generar PDF" target="_blank">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </a>
                                            
                                            {{-- No hay botones de Editar o Eliminar en reportes --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No se encontraron registros con los filtros seleccionados.
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
    <!-- FIN: Tarjeta de Tabla de Resultados -->


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

            // --- 1. ALERTA DE ÉXITO/ERROR (SweetAlert2) ---
            @if (session('success'))
                Swal.fire({
                    icon: 'success', title: '¡Éxito!', text: '{{ session('success') }}',
                    timer: 3000, showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
            @endif


            // --- 2. Lógica para MODAL VER FOTOS ---
            const modalVerFotos = document.getElementById('modalVerFotos');
            const galeriaFotos = document.getElementById('galeriaFotos');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const noFotos = document.getElementById('noFotos');

            if(modalVerFotos) {
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
                        if (!response.ok) throw new Error('Error al cargar fotos.');
                        
                        const fotos = await response.json();
                        loadingSpinner.style.display = 'none';

                        if (fotos.length > 0) {
                            fotos.forEach(foto => {
                                const img = document.createElement('img');
                                img.src = foto.url;
                                img.alt = foto.descripcion || 'Foto del panel';
                                img.className = 'img-thumbnail';
                                img.onclick = () => window.open(foto.url, '_blank');
                                galeriaFotos.appendChild(img);
                            });
                            galeriaFotos.style.display = 'grid';
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
            }

        });
    </script>
@endsection
{{-- FIN: Scripts de la página --}}