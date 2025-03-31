<?php

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

