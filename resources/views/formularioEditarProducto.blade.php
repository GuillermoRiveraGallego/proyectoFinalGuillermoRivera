<x-layout-header-producto-opciones>
    <div class="formularioProducto">
        <h2>Editar producto</h2>

        <form action="/actualizarProducto" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="campoFormulario">
                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ $producto->nombre }}" required>
            </div>

            <div class="campoFormulario">
                <label>Descripción</label>
                <textarea name="descripcion" required>{{ $producto->descripcion }}</textarea>
            </div>

            <div class="campoFormularioGrupo">
                <div class="campoFormulario mitad">
                    <label>Precio (€)</label>
                    <input type="number" step="0.01" name="precio" value="{{ $producto->precio }}" required>
                </div>

            </div>

            <div class="campoFormulario">
                <label>Categoría</label>
                <select name="categoria_id" required>
                    <option value="1" {{ $producto->categoria_id == 1 ? 'selected' : '' }}>Camisetas</option>
                    <option value="2" {{ $producto->categoria_id == 2 ? 'selected' : '' }}>Pantalones</option>
                    <option value="3" {{ $producto->categoria_id == 3 ? 'selected' : '' }}>Zapatillas</option>
                </select>
            </div>

            <div class="campoFormulario">
                <label>Imagen actual:</label>
                @php
                    $imagen = $producto->imagenes;
                @endphp
            @if ($imagen)
                    <img src="{{ asset($imagen) }}" alt="Imagen del producto" style="max-width: 200px;">
                @endif

                <label for="imagenes">Cambiar imagen</label>
                <input type="file" name="imagenes" accept="image/*">
                <input type="hidden" name="imagen_actual" value="{{ $imagen }}">
                <input type="hidden" name="id" value="{{ $producto->id }}">

            </div>

            <button type="submit" class="botonCompra">Actualizar producto</button>
        </form>
    </div>
</x-layout-header-producto-opciones>
