<x-layout-header-Inicio>

    <div class="vistaInicial">

        <div class="imagenInicial">
            <div class="contenedorImagenConBoton">
            <img src="Imagenes/prueba1.jpg">
                <a class="botonEncima" href="/vistaPrincipal">Ver productos</a>

            </div>
        </div>

        <div class="tresImagenesInicial">
            <div class="contenedorImagenConBoton">
            <img src="Imagenes/camisetaInicial.jpg">
                <a class="botonEncima" href="{{ route('productos.categoria', ['nombre' => 'Camisetas']) }}">Camisetas</a>
            </div>
            <div class="contenedorImagenConBoton">
            <img src="Imagenes/zapatillasInicial.png">
                <a class="botonEncima" href="{{ route('productos.categoria', ['nombre' => 'Zapatillas']) }}">Zapatillas</a>
            </div>
            <div class="contenedorImagenConBoton">
            <img src="Imagenes/pantalonInicial.jpg">
                <a class="botonEncima" href="{{ route('productos.categoria', ['nombre' => 'Pantalones']) }}">Pantalones</a>
            </div>
        </div>

    </div>

</x-layout-header-Inicio>
