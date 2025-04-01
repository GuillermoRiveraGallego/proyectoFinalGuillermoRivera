<?php

use App\Http\Controllers\UsuarioController;
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

Route::get('/zonaAdministracion', function () {
    return view('opcionesAdministracion');
})->name('admin.panel')->middleware(['auth', 'esAdmin']);
