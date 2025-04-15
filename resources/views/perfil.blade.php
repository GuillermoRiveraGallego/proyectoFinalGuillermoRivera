<x-layout-header-perfil>
    <div class="contenidoWebUnProducto">
        <div class="perfilContainer">
            <h2>Mi Perfil</h2>

            <div class="perfilDato">
                <span class="perfilLabel">Nombre de usuario:</span>
                <span>{{ $usuario->nombre_usuario }}</span>
            </div>

            <div class="perfilDato">
                <span class="perfilLabel">Nombre completo:</span>
                <span>{{ $usuario->nombre }} {{ $usuario->apellidos }}</span>
            </div>

            <div class="perfilDato">
                <span class="perfilLabel">Correo:</span>
                <span>{{ $usuario->correo }}</span>
            </div>

            <div class="perfilDato">
                <span class="perfilLabel">Miembro desde:</span>
                <span>{{ $usuario->created_at->format('d \d\e F \d\e Y') }}</span>
            </div>

            <div class="adminBotonContainer">
                <a href="/cerrarSesion" class="botonAdmin">
                    Cerrar Sesion
                </a>
            </div>

            @if($usuario->es_admin)
                <div class="adminBotonContainer">
                    <a href="/zonaAdministracion" class="botonAdmin">
                        Gestionar productos
                    </a>
                </div>
            @endif

            <h2>Mis Pedidos</h2>

            @if($pedidos->isEmpty())
                <p>No has realizado ningún pedido todavía.</p>
            @else
                <div class="listaPedidos">
                    @foreach($pedidos as $pedido)
                        <div class="pedidoItem">
                            <p><strong>Pedido #{{ $pedido->id }}</strong> — {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                            <p>Estado: <span class="estadoPedido">{{ ucfirst($pedido->estado) }}</span></p>
                            <p>Total: €{{ number_format($pedido->total, 2) }}</p>
                            @if($pedido->factura)
                                <a href="{{ route('descargar.factura', ['factura' => $pedido->factura->id]) }}" class="botonFactura">
                                    Descargar Factura 📄
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-layout-header-perfil>
