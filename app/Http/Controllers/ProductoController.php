<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = \App\Models\Producto::paginate(8);
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
        $producto = Producto::with('resenas.usuario')->findOrFail($id);

        $promedio = round($producto->resenas->avg('puntuacion'), 1);
        $cantidad = $producto->resenas->count();

        return view('unProducto', compact('producto', 'promedio', 'cantidad'));
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
            $producto->imagenes = $request->imagen_actual; // Conservar imagen anterior


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
        $talla = $request->input('talla'); // Capturamos la talla

        $producto = Producto::findOrFail($productoId);
        $carrito = session()->get('carrito', []);

        // Usamos ID + talla como clave única
        $clave = $productoId . '_' . $talla;

        if (isset($carrito[$clave])) {
            $carrito[$clave]['cantidad']++;
        } else {
            $carrito[$clave] = [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'imagen' => $producto->imagenes,
                'talla' => $talla,
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
        $clave = $request->input('producto_id'); // Ya es '12_42', por ejemplo
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$clave])) {
            if ($carrito[$clave]['cantidad'] > 1) {
                $carrito[$clave]['cantidad']--;
            } else {
                unset($carrito[$clave]);
            }

            session()->put('carrito', $carrito);
        }

        return redirect()->back()->with('success', 'Producto actualizado.');
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
        $fecha = now();

        // 1️⃣ Guardar la factura
        $factura = new Factura();
        $factura->usuario_id = Auth::id();
        $factura->total = $total;
        $factura->metodo_pago = 'Tarjeta'; // Puedes hacer esto dinámico en el futuro
        $factura->fecha_pago = $fecha;
        $factura->save();

        // 2️⃣ Crear el pedido asociado a esa factura
        $pedido = new Pedido();
        $pedido->usuario_id = Auth::id();
        $pedido->factura_id = $factura->id;
        $pedido->estado = 'pendiente'; // o 'pagado', según tu lógica
        $pedido->total = $total;
        $pedido->save();

        // 3️⃣ Guardar los productos del pedido
        foreach ($carrito as $clave => $item) {
            $productoId = explode('_', $clave)[0]; // Si tu clave es '12_M' o '15_42'

            PedidoProducto::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $productoId,
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio']
            ]);
        }

        // 4️⃣ Generar PDF
        $pdf = Pdf::loadView('facturaPDF', [
            'carrito' => $carrito,
            'total' => $total,
            'fecha' => $fecha->format('d/m/Y H:i')
        ]);

        session()->forget('carrito');

        return redirect()->route('carrito.ver')->with([
            'success' => '¡Pedido realizado con éxito!',
            'factura_id' => $factura->id
        ]);
    }



}





