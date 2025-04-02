<?php

use App\Http\Controllers\UsuarioController;
use App\Models\Producto;
use App\Models\Usuario;
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








/*Administracion*/
Route::get('/zonaAdministracion', function () {
    return view('opcionesAdministracion');
})->name('admin.panel')->middleware(['auth']); /*necesitaria el admin para comprobar*/





Route::get('/crearProducto', function () {
    return view('crearProducto');
})->name('crearProducto')->middleware(['auth']);

Route::post('/crearProducto', [ProductoController::class, 'funcionCrearProducto'])
    ->middleware(['auth'])
    ->name('crearProducto');





Route::get('/eliminarProducto', function () {
    $productos = Producto::orderBy('nombre', 'asc')->get();
    return view('eliminarProducto', compact('productos'));
})->name('eliminarProducto')->middleware(['auth']);

Route::post('/eliminarProducto', [ProductoController::class, 'funcionEliminarProducto'])->middleware(['auth'])->name('eliminarProducto');





Route::get('/editarProducto', function () {
    return view('editarProducto');
})->name('editarProducto')->middleware(['auth']);




Route::get('/eliminarUsuario', function () {
    $usuarios = Usuario::orderBy('nombre_usuario', 'asc')->get();
    return view('eliminarUsuario', compact('usuarios'));
})->name('eliminarUsuario')->middleware(['auth']);

Route::post('/eliminarUsuario', [UsuarioController::class, 'funcionEliminarUsuario'])
    ->middleware(['auth'])
    ->name('eliminarUsuario');




Route::get('/hacerAdmin', function () {
    return view('hacerAdmin');
})->name('hacerAdmin')->middleware(['auth']);


Route::get('/hacerAdmin', function () {
    $usuarios = Usuario::orderBy('nombre_usuario', 'asc')->get();
    return view('hacerAdmin', compact('usuarios'));
})->name('hacerAdmin')->middleware(['auth']);

Route::post('/hacerAdmin', [UsuarioController::class, 'funcionHacerAdmin'])
    ->middleware(['auth'])
    ->name('hacerAdmin');
