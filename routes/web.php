<?php

use App\Http\Controllers\ResenasController;
use App\Http\Controllers\UsuarioController;
use App\Models\Factura;
use App\Models\Producto;
use App\Models\Usuario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('vistaInicial');
});

Route::get('/vistaPrincipal', [ProductoController::class, 'index'])->name('productos.vista');

Route::get('/productos/categoria/{nombre}', [ProductoController::class, 'filtrarPorCategoria'])->name('productos.categoria');


Route::get('/uno', function () {
    return view('unProducto');
});

Route::get('/producto/{id}', [ProductoController::class, 'mostrar'])->name('producto.mostrar');

// Página de login (formulario)
Route::get('/login', [UsuarioController::class, 'mostrarLogin'])->name('login');



Route::view('/registro', 'registro')->name('registro');


Route::post('/registro', [UsuarioController::class,'create']);

Route::post('/login', [UsuarioController::class,'comprobarLogin']);

Route::get('/perfilUsuario', [UsuarioController::class, 'verPerfil'])
    ->name('perfil.usuario')
    ->middleware('auth');


Route::get('/cerrarSesion', [UsuarioController::class, 'usuarioCerrarSesion'])
    ->name('usuarioCerrarSesion')
    ->middleware('auth');





/*Administracion*/
Route::get('/zonaAdministracion', function () {
    return view('opcionesAdministracion');
})->name('admin.panel')->middleware('auth:admin');





Route::get('/crearProducto', function () {
    return view('crearProducto');
})->name('crearProducto')->middleware('auth:admin');

Route::post('/crearProducto', [ProductoController::class, 'funcionCrearProducto'])
    ->middleware(['auth'])
    ->middleware('auth:admin');





Route::get('/eliminarProducto', function () {
    $productos = Producto::orderBy('nombre', 'asc')->get();
    return view('eliminarProducto', compact('productos'));
})->name('eliminarProducto')->middleware('auth:admin');

Route::post('/eliminarProducto', [ProductoController::class, 'funcionEliminarProducto'])->middleware('auth:admin')->name('eliminarProducto');




Route::get('/editarProducto', function () {
    $productos = Producto::orderBy('nombre', 'asc')->get();
    return view('editarProducto', compact('productos'));
})->name('editarProducto')->middleware('auth:admin');

Route::post('/editarProductoForm', [ProductoController::class, 'mostrarFormularioEditar'])
    ->middleware('auth:admin')
    ->name('editarProductoForm');

Route::post('/actualizarProducto', [ProductoController::class, 'funcionActualizarProducto'])
    ->middleware('auth:admin')
    ->name('actualizarProducto');








Route::get('/eliminarUsuario', function () {
    $usuarios = Usuario::orderBy('nombre_usuario', 'asc')->get();
    return view('eliminarUsuario', compact('usuarios'));
})->name('eliminarUsuario')->middleware('auth:admin');

Route::post('/eliminarUsuario', [UsuarioController::class, 'funcionEliminarUsuario'])
    ->middleware('auth:admin')
    ->name('eliminarUsuario');




Route::get('/hacerAdmin', function () {
    return view('hacerAdmin');
})->name('hacerAdmin')->middleware('auth:admin');


Route::get('/hacerAdmin', function () {
    $usuarios = Usuario::orderBy('nombre_usuario', 'asc')->get();
    return view('hacerAdmin', compact('usuarios'));
})->name('hacerAdmin')->middleware('auth:admin');

Route::post('/hacerAdmin', [UsuarioController::class, 'funcionHacerAdmin'])
    ->middleware('auth:admin')
    ->name('hacerAdmin');



Route::get('/buscar-productos', [ProductoController::class, 'buscar'])->name('productos.buscar');




Route::post('/carrito/agregar', [ProductoController::class, 'agregarAlCarrito'])->middleware('auth')->name('carrito.agregar');
Route::get('/carrito', [ProductoController::class, 'verCarrito'])->middleware('auth')->name('carrito.ver');
Route::post('/carrito/eliminar-unidad', [ProductoController::class, 'eliminarUnidad'])->name('carrito.eliminarUnidad');
Route::post('/carrito/eliminar-producto', [ProductoController::class, 'eliminarProducto'])->name('carrito.eliminarProducto');

Route::get('/carrito/compra', [ProductoController::class, 'generarFactura'])->name('carrito.factura')->middleware('auth');





Route::get('/factura/{factura}', function(Factura $factura) {
    $pedido = $factura->pedido;

    if (!$pedido) {
        return redirect()->back()->with('error', 'No se ha encontrado el pedido asociado a esta factura.');
    }

    $productos = $pedido->productos; // relación con pedidos_productos
    $total = $pedido->total;
    $fecha = \Carbon\Carbon::parse($factura->fecha_pago)->format('d/m/Y H:i');

    $pdf = Pdf::loadView('facturaPDF', compact('productos', 'total', 'fecha'));

    return $pdf->download('Factura_FutsalWear.pdf');
})->name('descargar.factura')->middleware('auth');









Route::post('/resenas/guardar', [ResenasController::class, 'guardar'])->name('resenas.guardar')->middleware('auth');

