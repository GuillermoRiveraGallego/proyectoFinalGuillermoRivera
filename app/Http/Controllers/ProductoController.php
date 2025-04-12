<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = \App\Models\Producto::paginate(12);
        return view('vistaPrincipal', ['producto' => $productos, 'categoriaSeleccionada' => ""]);
    }

    public function filtrarPorCategoria($nombre) {
        $categoria = Categoria::where('nombre', $nombre)->firstOrFail();

        $productos = Producto::where('categoria_id', $categoria->id)->paginate(8);

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


    public function mostrarFormularioEditar(Request $request)
    {
        $producto = Producto::find($request->producto_id);

        if (!$producto) {
            return redirect()->route('editarProducto')->with('error', 'Producto no encontrado.');
        }

        return view('formularioEditarProducto', compact('producto'));
    }


    public function funcionActualizarProducto(Request $request)
    {
        $producto = Producto::findOrFail($request->id); // O usa el ID desde la ruta si prefieres

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'required|in:1,2,3',
        ]);

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->categoria_id = $request->categoria_id;

        if ($request->hasFile('imagenes')) {
            $rutaImagen = time() . '_' . $request->file('imagenes')->getClientOriginalName();
            $request->file('imagenes')->move(public_path('Imagenes'), $rutaImagen);
            $producto->imagenes = "Imagenes/" . $rutaImagen;
        } elseif ($request->filled('imagen_actual')) {
            $producto->imagenes = json_encode([$request->imagen_actual]); // Conservar imagen anterior
        }


        $producto->save();

        return redirect("/login");
    }


    public function buscar(Request $request)
    {
        $busqueda = $request->input('q');
        $categoriaNombre = $request->input('categoria');

        $query = Producto::query();

        if (!empty($categoriaNombre)) {
            $categoria = Categoria::where('nombre', $categoriaNombre)->first();
            if ($categoria) {
                $query->where('categoria_id', $categoria->id);
            }
        }

        if (!empty($busqueda)) {
            $query->where('nombre', 'like', '%' . $busqueda . '%');
        }

        $productos = $query->paginate(12)->withQueryString();




        return view('vistaPrincipal', [
            'producto' => $productos,
            'categoriaSeleccionada' => $categoriaNombre ?? ''
        ]);
    }

    public function agregarAlCarrito(Request $request)
    {
        $productoId = $request->input('producto_id');
        $producto = Producto::findOrFail($productoId);

        $carrito = session()->get('carrito', []);

        // Si ya está en el carrito, incrementa la cantidad
        if (isset($carrito[$productoId])) {
            $carrito[$productoId]['cantidad']++;
        } else {
            $carrito[$productoId] = [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'imagen' => $producto->imagenes,
                'cantidad' => 1,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->back()->with('success', 'Producto añadido al carrito.');
    }



    public function verCarrito()
    {
        $carrito = session('carrito', []);
        return view('carrito', compact('carrito'));
    }


    public function eliminarUnidad(Request $request)
    {
        $carrito = session('carrito', []);

        $productoId = $request->input('producto_id');

        if (isset($carrito[$productoId])) {
            if ($carrito[$productoId]['cantidad'] > 1) {
                $carrito[$productoId]['cantidad']--;
            } else {
                unset($carrito[$productoId]);
            }
            session(['carrito' => $carrito]);
        }

        return redirect()->back();
    }

    public function eliminarProducto(Request $request)
    {
        $carrito = session('carrito', []);

        $productoId = $request->input('producto_id');

        unset($carrito[$productoId]);

        session(['carrito' => $carrito]);

        return redirect()->back();
    }





    public function generarFactura()
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }

        $total = collect($carrito)->sum(fn($item) => $item['precio'] * $item['cantidad']);
        $fecha = now()->format('d/m/Y H:i');

        $pdf = Pdf::loadView('facturaPDF', compact('carrito', 'total', 'fecha'));

        // Simula vaciar carrito tras compra
        session()->forget('carrito');

        return $pdf->download('Factura_FutsalWear.pdf');
    }


}





