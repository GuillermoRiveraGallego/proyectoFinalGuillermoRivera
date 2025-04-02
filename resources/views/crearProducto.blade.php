<x-layout-header-producto-opciones>
    <div class="contenidoWebUnProducto">
        <div class="zonaAdmin formularioProducto">
            <h2>Crear nuevo producto</h2>

            <form action="/crearProducto" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="campoFormulario">
                    <label for="nombre">Nombre del producto</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>

                <div class="campoFormulario">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" required></textarea>
                </div>

                <div class="campoFormularioGrupo">
                    <div class="campoFormulario mitad">
                        <label for="precio">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" id="precio" required>
                    </div>
                </div>

                <div class="campoFormulario">
                    <label for="categoria_id">Categoría</label>
                    <select name="categoria_id" id="categoria_id" required>
                        <option value="" disabled selected>Selecciona una categoría</option>
                        <option value="1">Camisetas</option>
                        <option value="2">Pantalones</option>
                        <option value="3">Zapatillas</option>
                    </select>
                </div>

                <div class="campoFormulario">
                    <label for="imagenes">Imagen del producto</label>
                    <input type="file" name="imagenes" id="imagenes" accept="image/*" required>
                </div>

                <button type="submit" class="botonCompra">Crear producto</button>

                @if(session('success'))
                    <div class="alertaExito">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alertaError">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-layout-header-producto-opciones>
