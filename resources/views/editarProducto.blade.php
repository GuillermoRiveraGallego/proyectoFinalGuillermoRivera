<x-layout-header-perfil>
    <div class="contenidoWebUnProducto">
        <div class="zonaAdmin">
            <h2>Selecciona un producto para editar</h2>

            <form action="/editarProductoForm" method="POST">
                @csrf

                <select name="producto_id" class="selectorProducto">
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}">
                            {{ $producto->nombre }} - €{{ number_format($producto->precio, 2) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="botonAdminAccion">editar</button>
                @if(session('success'))
                    <div class="alertaExito">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alertaError">
                        {{ session('error') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-layout-header-perfil>
