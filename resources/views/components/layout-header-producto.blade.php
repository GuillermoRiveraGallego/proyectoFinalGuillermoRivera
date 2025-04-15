<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutsalWear</title>
    <link rel="shortcut icon" href="../imagenesWEB/iconoBg.png" type="image/x-icon">
    <link rel="stylesheet" href="{{URL::asset('css/estilosUnProducto.css')}}">
    <script type="text/javascript" src="../../../public/js/jquery-3.7.1.js"></script>
</head>

<body class="bodyInicio">

<header>
    <div class="headerTituloYlogo">
        <img class="logoHeader" src="/Imagenes/iconoBg1.png" alt="Logo FUTSALWEAR">
        <div class="tituloHeader"><a href="{{ url('/') }}">FUTSALWEAR</a></div>
    </div>

    <div class="linksHeader">
        <a href="/perfilUsuario">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </a>
        @php
            $totalCarrito = session('carrito') ? array_sum(array_column(session('carrito'), 'cantidad')) : 0;
        @endphp

        <a href="/carrito" class="carritoIcono">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="lucide lucide-shopping-cart">
                <circle cx="8" cy="21" r="1"/>
                <circle cx="19" cy="21" r="1"/>
                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
            </svg>

            @if($totalCarrito > 0)
                <span class="carritoCantidad">{{ $totalCarrito }}</span>
            @endif
        </a>
        <div class="buscadorHeader">
        </div>
    </div>
</header>


{{$slot}}


<footer>
    <div class="contenedorLogos">
        <a href=""><img class="logos" src="/Imagenes/instagramLogo.jpg" alt="instagram Logo"></a>
        <a href=""><img class="logos" src="/Imagenes/twitterLogo.jpg" alt="twitter Logo"></a>
        <a href=""><img class="logos" src="/Imagenes/tiktokLogo.jpg" alt="tiktok Logo"></a>
    </div>
</footer>

</body>

</html>

