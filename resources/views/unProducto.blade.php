<x-layout-header-producto>

    <div class="contenidoWebUnProducto">
        <aside class="menuLateral">
            <a href="{{ route('productos.vista') }}" class="botonCompra">Volver</a>

        </aside>

        <section class="productoDetalle">
            <div class="imagenProducto">
                @if ($producto->imagenes)
                    <img src="{{ asset($producto->imagenes) }}" alt="Imagen del producto">
                @endif

            </div>

            <div class="infoProducto">
                <h2>{{ $producto->nombre }}</h2>
                <p class="descripcion">{{ $producto->descripcion }}</p>
                <p class="precio">€{{ number_format($producto->precio, 2) }}</p>

                <div class="opcionesCompra">
                    <label for="talla">Talla:</label>
                    <select id="talla" name="talla">
                        @if ($producto->categoria_id == 3)
                            {{-- Zapatillas --}}
                            @foreach (range(38, 46) as $talla)
                                <option value="{{ $talla }}">{{ $talla }}</option>
                            @endforeach
                        @else
                            {{-- Camisetas, pantalones... --}}
                            @foreach (['S', 'M', 'L', 'XL'] as $talla)
                                <option value="{{ $talla }}">{{ $talla }}</option>
                            @endforeach
                        @endif
                    </select>


                    <form method="POST" action="{{ route('carrito.agregar') }}">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        <input type="hidden" name="talla" id="input-talla" value="">
                        <button type="submit" class="botonCompra">Añadir al carrito 🛒</button>
                    </form>

                </div>
            </div>

        </section>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selectTalla = document.getElementById("talla");
            const inputTalla = document.getElementById("input-talla");

            selectTalla.addEventListener("change", function () {
                inputTalla.value = this.value;
            });

            inputTalla.value = selectTalla.value;
        });
    </script>

</x-layout-header-producto>
