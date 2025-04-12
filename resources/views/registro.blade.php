<x-layout-header-login>
    <div class="inicioSesion" style="margin-top: 6em; padding: 2em;">
        <form method="POST" action="/registro" class="formularioRegistro">
            <h2>Registrarse</h2>
            @csrf

            <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" class="inputRegistro" required>
            <input type="text" name="nombre" placeholder="Nombre" class="inputRegistro" required>
            <input type="text" name="apellidos" placeholder="Apellidos" class="inputRegistro" required>
            <input type="email" name="correo" placeholder="Correo electrónico" class="inputRegistro" required>
            <input type="password" name="contrasena" placeholder="Contraseña" class="inputRegistro" required>

            <button type="submit" class="botonCompra">Crear cuenta</button>
        </form>
    </div>
</x-layout-header-login>
