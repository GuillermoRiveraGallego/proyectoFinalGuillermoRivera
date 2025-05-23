<x-layout-header :categoriaSeleccionada="$categoriaSeleccionada">

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const desplegable = document.querySelector(".desplegableCategorias");
            const boton = document.querySelector(".botonDesplegable");

            function ajustarDesplegable() {
                if (window.innerWidth > 1024) {
                    desplegable.style.display = "block";
                } else {
                    desplegable.style.display = "none";
                }
            }

            ajustarDesplegable();

            if (boton) {
                boton.addEventListener("click", () => {
                    desplegable.style.display =
                        desplegable.style.display === "none" ? "block" : "none";
                });
            }

            window.addEventListener("resize", ajustarDesplegable);
        });
    </script>

    <div class="contenidoWeb">
        <!-- Menú lateral -->
        <aside class="menuLateral">
            <h3 class="botonDesplegable">Categorías ▼</h3>
            <ul class="desplegableCategorias">
                <li>
                    <a href="/vistaPrincipal"
                       class="{{ $categoriaSeleccionada === '' ? 'categoriaActiva' : '' }}">

                        Todos los productos
                    </a>
                </li>
                <li>
                    <a href="{{ route('productos.categoria', ['nombre' => 'Camisetas']) }}"
                       class="{{ $categoriaSeleccionada === 'Camisetas' ? 'categoriaActiva' : '' }}">

                        Camisetas
                    </a>
                </li>
                <li>
                    <a href="{{ route('productos.categoria', ['nombre' => 'Pantalones']) }}"
                       class="{{ $categoriaSeleccionada === 'Pantalones' ? 'categoriaActiva' : '' }}">
                        Pantalones
                    </a>
                </li>
                <li>
                    <a href="{{ route('productos.categoria', ['nombre' => 'Zapatillas']) }}"
                       class="{{ $categoriaSeleccionada === 'Zapatillas' ? 'categoriaActiva' : '' }}">
                        Zapatillas
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Sección de productos -->
        <section class="productos {{ $producto->isEmpty() ? 'productosVacio' : '' }}">

        @if ($producto->isEmpty())
                <div class="noProductos">
                    <p>No hay productos disponibles.</p>
                </div> @endif

            @foreach ($producto as $po)
                <div class="producto">
                    <a href="{{ route('producto.mostrar', $po->id) }}">
                        <div class="imagen-wrapper">
                            <img src="{{ asset($po->imagenes) }}" alt="Imagen del producto">
                        </div>
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
