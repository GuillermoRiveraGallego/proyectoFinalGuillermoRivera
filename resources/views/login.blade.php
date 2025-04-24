<x-layout-header-login>
    <div class="inicioSesion" style="margin-top: 6em; padding: 2em;">




        <form method="POST" action="/login" onsubmit="deshabilitarBoton(this)">
            @if(session('success'))
                <div style="color: green; margin-bottom: 1em; text-align: center;">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div style="color: red; margin-bottom: 1em; text-align: center;">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2>Iniciar sesión</h2>
            @csrf

            <input type="text" name="correo" placeholder="Correo" value="{{ old('correo') }}" required><br><br>
            <input type="password" name="contrasena" placeholder="Contraseña" required><br><br>

            <button type="submit" class="botonCompra">Entrar</button>

            <div style="margin-top: 1.5em; text-align: center;">
                <p>¿No tienes cuenta?</p>
                <a href="/registro" class="botonCompra">Registrarse</a>
            </div>
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
