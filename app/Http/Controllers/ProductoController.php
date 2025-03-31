<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = \App\Models\Producto::paginate(12);
        return view('vistaPrincipal', ['producto' => $productos]);
    }

    public function filtrarPorCategoria($nombre) {

    $categoria = Categoria::where('nombre', $nombre)->firstOrFail();

    $productos = Producto::where('categoria_id', $categoria->id)->paginate(12);

    return view('vistaPrincipal', [
        'producto' => $productos,
        'categoriaSeleccionada' => $categoria->nombre
    ]);
    }

    public function mostrar($id)
    {
        $producto = Producto::findOrFail($id);
        return view('unProducto', compact('producto'));
    }
}





