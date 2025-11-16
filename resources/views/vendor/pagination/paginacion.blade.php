@if ($paginator->hasPages())
    <nav>
        <div class="btn-group" role="group" aria-label="Pagination">
            
            {{-- Botón "Anterior" --}}
            @if ($paginator->onFirstPage())
                <button type="button" class="btn btn-outline-info" disabled>
                    <i class="bi bi-chevron-left"></i>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-info">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            {{-- Elementos de Paginación (Números) --}}
            @foreach ($elements as $element)
                {{-- Separador "..." --}}
                @if (is_string($element))
                    <button type="button" class="btn btn-outline-info" disabled>{{ $element }}</button>
                @endif

                {{-- Array de Números de Página --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- Página activa: usamos 'btn-info' para resaltarla --}}
                            <button type="button" class="btn btn-info active" disabled>{{ $page }}</button>
                        @else
                            {{-- Página normal --}}
                            <a href="{{ $url }}" class="btn btn-outline-info">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botón "Siguiente" --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-info">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <button type="button" class="btn btn-outline-info" disabled>
                    <i class="bi bi-chevron-right"></i>
                </button>
            @endif

        </div>
    </nav>
@endif