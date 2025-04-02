<x-layout-header>
    <div class="contenidoWeb">
        <!-- Menú lateral -->
        <aside class="menuLateral">
            <h3 class="botonDesplegable">Categorías ▼</h3>
            <ul class="desplegableCategorias">
                <li><a href="{{ route('productos.categoria', ['nombre' => 'Camisetas']) }}">Camisetas</a></li>
                <li><a href="{{ route('productos.categoria', ['nombre' => 'Pantalones']) }}">Pantalones</a></li>
                <li><a href="{{ route('productos.categoria', ['nombre' => 'Zapatillas']) }}">Zapatillas</a></li>
            </ul>
        </aside>

        <!-- Sección de productos -->
        <section class="productos">
            @foreach ($producto as $po)
                <div class="producto">
                    <a href="{{ route('producto.mostrar', $po->id) }}">
                        <img src="{{ asset($po->imagenes) }}" alt="Imagen del producto">
                    </a>
                        <h4>{{ $po->nombre }}</h4>
                        <p>€{{ number_format($po->precio, 2) }}</p>

                </div>
            @endforeach
        </section>


    </div>

    <div class="paginacion">
        @if ($producto->previousPageUrl())
            <a href="{{ $producto->previousPageUrl() }}" class="botonDePagina">&laquo; Anterior</a>
        @endif

        <span class="paginaActual">Página {{ $producto->currentPage() }} de {{ $producto->lastPage() }}</span>

        @if ($producto->nextPageUrl())
            <a href="{{ $producto->nextPageUrl() }}" class="botonDePagina">Siguiente &raquo;</a>
        @endif
    </div>
</x-layout-header>
