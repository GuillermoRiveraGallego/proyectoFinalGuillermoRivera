<?php

use Illuminate\Support\Facades\Route;

Route::get('/vistaPrincipal', function () {
    return view('vistaPrincipal')->with("producto",\App\Models\Producto::all());
});

Route::get('/', function () {
    return view('vistaInicial');
});


