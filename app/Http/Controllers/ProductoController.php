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

    public function funcionEliminarProducto(Request $request)
    {
        $producto = Producto::find($request->producto_id);

        if ($producto) {
            $producto->delete();
            return redirect()->route('eliminarProducto')->with('success', 'Producto eliminado correctamente.');
        }

        return redirect()->back()->with('error', 'Producto no encontrado.');
    }

    public function funcionCrearProducto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagenes' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        // Guardar imagen en carpeta /public/Imagenes
        if ($request->hasFile('imagenes')) {
            $imagen = $request->file('imagenes');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('Imagenes'), $nombreImagen);
            $rutaImagen = 'Imagenes/' . $nombreImagen;
        } else {
            // Por si acaso, aunque en el formulario es obligatorio
            $rutaImagen = 'Imagenes/default.png';
        }

        // Crear producto
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->stock = "1";
        $producto->categoria_id = $request->categoria_id;
        $producto->imagenes = $rutaImagen; // No en JSON, solo texto plano
        $producto->save();

        return redirect()->route('crearProducto')->with('success', 'Producto creado correctamente.');
    }

}





