<x-layout-header-login>
    <div class="inicioSesion" style="margin-top: 6em; padding: 2em;">

        <form method="POST" action="/login">
            <h2>Iniciar sesión</h2>
            @csrf
            <input type="text" name="correo" placeholder="Correo" required><br><br>
            <input type="password" name="contrasena" placeholder="Contraseña" required><br><br>
            <button type="submit" class="botonCompra">Entrar</button>
            <div style="margin-top: 1.5em; text-align: center;">
                <p>¿No tienes cuenta?</p>
                <a href="/registro" class="botonCompra" > Registrarse </a>
            </div>
        </form>

    </div>
</x-layout-header-login>

