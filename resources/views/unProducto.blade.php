<x-layout-header-producto>
    <div class="contenidoWebUnProducto">
        <aside class="menuLateral">
            <a href="{{ url()->previous() }}" class="botonCompra">Volver</a>
        </aside>

        <section class="productoDetalle">
            <div class="imagenProducto">
                @php
                    $imagen = collect(json_decode($producto->imagenes))->first();
                @endphp

                @if ($imagen)
                    <img src="{{ asset($imagen) }}" alt="Imagen del producto">
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

                    <button class="botonCompra">Añadir al carrito 🛒</button>
                </div>
            </div>
        </section>
    </div>
</x-layout-header-producto>
