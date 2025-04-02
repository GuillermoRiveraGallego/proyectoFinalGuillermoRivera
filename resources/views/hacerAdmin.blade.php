<x-layout-header-perfil>
    <div class="contenidoWebUnProducto">
        <div class="zonaAdmin">
            <h2>Selecciona el usuario al que hacer admin</h2>

            <form action="/hacerAdmin" method="POST">
                @csrf

                <select name="usuario_id" class="selectorProducto">
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">
                            {{ $usuario->nombre_usuario }} - {{ $usuario->correo }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="botonAdminAccion">Hacer admin</button>

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

