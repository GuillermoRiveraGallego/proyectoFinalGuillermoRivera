<x-layout-header-login>
    <div class="inicioSesion" style="margin-top: 6em; padding: 2em;">
        <form method="POST" action="/registro" class="formularioRegistro" onsubmit="deshabilitarBoton(this)">
            <h2>Registrarse</h2>

            @if ($errors->any())
                <div class="erroresRegistro" style="color: red; margin-bottom: 1em;">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf

            <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" class="inputRegistro" value="{{ old('nombre_usuario') }}" required>

            <input type="text" name="nombre" placeholder="Nombre" class="inputRegistro" value="{{ old('nombre') }}" required>

            <input type="text" name="apellidos" placeholder="Apellidos" class="inputRegistro" value="{{ old('apellidos') }}" required>

            <input type="email" name="correo" placeholder="Correo electrónico *" class="inputRegistro" value="{{ old('correo') }}" required>

            <input type="password" name="contrasena" placeholder="Contraseña *" class="inputRegistro" required>

            <button type="submit" class="botonCompra">Crear cuenta</button>
        </form>
    </div>

    <script>
        function deshabilitarBoton(formulario) {
            const boton = formulario.querySelector("button[type='submit']");
            boton.disabled = true;
            boton.innerHTML = "Entrando..."; // opcional: puedes personalizar el texto
        }
    </script>


</x-layout-header-login>
