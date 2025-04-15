<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            padding: 20px;
        }

        h1 {
            color: #B22222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }

    </style>
</head>
<body>
<h1>Factura - FutsalWear</h1>
<p><strong>Fecha:</strong> {{ $fecha }}</p>

<table>
    <thead>
    <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio unitario</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($carrito))
        @foreach($carrito as $item)
            <tr>
                <td>{{ $item['nombre'] }}</td>
                <td>{{ $item['cantidad'] }}</td>
                <td>€{{ number_format($item['precio'], 2) }}</td>
                <td>€{{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
            </tr>
        @endforeach
    @elseif(isset($productos))
        @foreach($productos as $item)
            <tr>
                <td>{{ $item->producto->nombre ?? 'Producto eliminado' }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>€{{ number_format($item->precio_unitario, 2) }}</td>
                <td>€{{ number_format($item->cantidad * $item->precio_unitario, 2) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>

</table>

<p class="total">Total: €{{ number_format($total, 2) }}</p>
</body>
</html>
