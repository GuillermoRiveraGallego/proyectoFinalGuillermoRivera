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
                    <select id="talla">
                        <option>S</option>
                        <option>M</option>
                        <option>L</option>
                        <option>XL</option>
                    </select>

                    <form method="POST" action="{{ route('carrito.agregar') }}">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        <button type="submit" class="botonCompra">Añadir al carrito 🛒</button>
                    </form>

                </div>
            </div>

        </section>
    </div>
</x-layout-header-producto>
