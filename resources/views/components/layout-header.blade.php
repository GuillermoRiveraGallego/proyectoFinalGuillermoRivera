<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutsalWear</title>
    <link rel="shortcut icon" href="../imagenesWEB/iconoBg.png" type="image/x-icon">
    <link rel="stylesheet" href="{{URL::asset('css/estilosIndexPrincipal.css')}}">
    <script type="text/javascript" src="../../../public/js/jquery-3.7.1.js"></script>
</head>

<body>

<header>

    <div class="headerTituloYlogo">
        <img class="logoHeader" src="/Imagenes/iconoBg1.png" alt="Logo FUTSALWEAR">
        <div class="tituloHeader"><a href="{{ url('/') }}">FUTSALWEAR</a></div>
    </div>

    <div class="linksHeader">
        <a href="/perfilUsuario">&#128100;</a>
        <a href="/carrito">&#128722;</a>
        <form action="{{ route('productos.buscar') }}" method="GET" class="buscadorHeader">
            <input type="text" name="q" placeholder="¿Qué estás buscando?" value="{{ request('q') }}">
            @if (!empty($categoriaSeleccionada))
                <input type="hidden" name="categoria" value="{{ $categoriaSeleccionada }}">
            @endif
        </form>


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

