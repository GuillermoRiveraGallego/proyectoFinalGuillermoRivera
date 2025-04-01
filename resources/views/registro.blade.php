<x-layout-header-login>
    <div class="inicioSesion" style="margin-top: 6em; padding: 2em;">
        <form method="POST" action="/registro">
            <h2>Registrarse</h2>
            @csrf

            <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" required><br><br>
            <input type="text" name="nombre" placeholder="Nombre" required><br><br>
            <input type="text" name="apellidos" placeholder="Apellidos" required><br><br>
            <input type="email" name="correo" placeholder="Correo electrónico" required><br><br>
            <input type="password" name="contrasena" placeholder="Contraseña" required><br><br>

            <button type="submit" class="botonCompra">Crear cuenta</button>
        </form>
    </div>
</x-layout-header-login>
