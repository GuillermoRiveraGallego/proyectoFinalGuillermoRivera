<x-layout-header-perfil>

    <div class="contenedorCarritoCompra">
        <div class="contenedorInternoCarritoCompra">

            <h2 class="tituloCarrito">🛒 Tu carrito de compra</h2>

            @if(empty($carrito))
                <p class="carritoVacio">Tu carrito está vacío.</p>
            @else
                <div class="listaCarrito">
                    @foreach($carrito as $id => $item)
                        <div class="itemCarrito">
                            <img src="{{ asset($item['imagen']) }}" alt="Producto" class="imagenCarrito">
                            <div class="infoCarrito">
                                <p class="nombreProducto">{{ $item['nombre'] }}</p>
                                <p>{{ $item['cantidad'] }} x €{{ number_format($item['precio'], 2) }}</p>

                                <form action="{{ route('carrito.eliminarUnidad') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="producto_id" value="{{ $id }}">
                                    <button type="submit" class="botonEliminar">Quitar 1</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="totalCarrito">
                    <p><strong>Total:</strong> €
                        {{ number_format(collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']), 2) }}
                    </p>
                    <button class="botonCompra" >Comprar ahora</button>
                </div>
            @endif

        </div>
    </div>

</x-layout-header-perfil>
