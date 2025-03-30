<x-layout-header>
    <div class="contenidoWeb">
        <!-- Menú lateral -->
        <aside class="menuLateral">
            <h3 class="botonDesplegable">Categorías ▼</h3>
            <ul class="desplegableCategorias">
                <li><a href="#">Camisetas</a></li>
                <li><a href="#">Pantalones</a></li>
                <li><a href="#">Calzado</a></li>
            </ul>
        </aside>

        <!-- Sección de productos -->
        <section class="productos">
            @foreach ($producto as $po)
                <div class="producto">

                    @php
                        $imagen = collect(json_decode($po->imagenes))->first();
                    @endphp

                    @if ($imagen)
                        <img src="{{ asset($imagen) }}" alt="Imagen del producto">
                    @endif

                    <h4>{{ $po->nombre }}</h4>
                    <p>€19.99</p>
                </div>
            @endforeach
        </section>
    </div>
</x-layout-header>
