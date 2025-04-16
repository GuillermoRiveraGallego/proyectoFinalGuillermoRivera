<x-layout-header-producto>

    <div class="contenidoWebUnProducto">
        <aside class="menuLateral">
            <a href="{{ route('productos.vista') }}" class="botonCompra">Volver</a>

        </aside>

        <div>

        <section class="productoDetalle">

            <div class="imagenProducto">
                @if ($producto->imagenes)
                    <img src="{{ asset($producto->imagenes) }}" alt="Imagen del producto">
                @endif

            </div>

            <div class="infoProducto">
                <h2>{{ $producto->nombre }}</h2>
                <p class="descripcion">{{ $producto->descripcion }}</p>
                <p class="precio">€{{ number_format($producto->precio, 2) }}</p>

                <div class="opcionesCompra">
                    <label for="talla">Talla:</label>
                    <select id="talla" name="talla">
                        @if ($producto->categoria_id == 3)
                            {{-- Zapatillas --}}
                            @foreach (range(38, 46) as $talla)
                                <option value="{{ $talla }}">{{ $talla }}</option>
                            @endforeach
                        @else
                            {{-- Camisetas, pantalones... --}}
                            @foreach (['S', 'M', 'L', 'XL'] as $talla)
                                <option value="{{ $talla }}">{{ $talla }}</option>
                            @endforeach
                        @endif
                    </select>


                    <form method="POST" action="{{ route('carrito.agregar') }}">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        <input type="hidden" name="talla" id="input-talla" value="">
                        <button type="submit" class="botonCompra">Añadir al carrito
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="lucide lucide-shopping-cart">
                                <circle cx="8" cy="21" r="1"/>
                                <circle cx="19" cy="21" r="1"/>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                            </svg></button>
                    </form>



                </div>
            </div>

        </section>
            @if(session('success'))
                <div class="mensajeExito">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mensajeError">
                    {{ session('error') }}
                </div>
            @endif
            <div class="resenasContainer">
                <div class="resenasContainerInterno">
                    <div class="resenasResumen" onclick="toggleResenas()">
                        <strong>Valoraciones ({{ $cantidad }})</strong>
                        <div class="estrellasResumen">
                            <span>{{ $promedio }}</span>
                            @for($i = 1; $i <= 5; $i++)
                                <span style="color: #00C853;">
                    @if($promedio >= $i)
                                        ★
                                    @elseif($promedio >= $i - 0.5)
                                        ☆
                                    @else
                                        ☆
                                    @endif
                </span>
                            @endfor
                            <span style="transform: rotate(90deg); display: inline-block;">⌵</span>
                        </div>
                    </div>

                    <div class="resenasLista" id="resenasLista" style="display: none;">
                        @foreach($producto->resenas as $resena)
                            <div class="resenaItem">
                                <strong>{{ $resena->usuario->nombre_usuario ?? 'Usuario' }}</strong>
                                <span style="color: #00C853;">
                    @for($i = 1; $i <= 5; $i++)
                                        {{ $resena->puntuacion >= $i ? '★' : '☆' }}
                                    @endfor
                </span>
                                <p>{{ $resena->comentario }}</p>
                                <small>{{ $resena->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        @endforeach

                        @auth
                            <form action="{{ route('resenas.guardar') }}" method="POST" class="formResena">
                                @csrf
                                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                                <label for="puntuacion">Puntuación:</label>
                                <select name="puntuacion" required>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} estrella{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>

                                <label for="comentario">Comentario:</label>
                                <textarea name="comentario" rows="3" required></textarea>

                                <button type="submit" class="botonCompra">Enviar reseña</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
    </div>

    </div>

    <script>
        // Esta función ahora es accesible globalmente
        function toggleResenas() {
            const lista = document.getElementById("resenasLista");
            lista.style.display = lista.style.display === "none" ? "block" : "none";
        }

        document.addEventListener("DOMContentLoaded", function () {
            const selectTalla = document.getElementById("talla");
            const inputTalla = document.getElementById("input-talla");

            selectTalla.addEventListener("change", function () {
                inputTalla.value = this.value;
            });

            inputTalla.value = selectTalla.value;
        });
    </script>


</x-layout-header-producto>
