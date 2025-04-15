<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class ResenasController extends Controller

{
    public function guardar(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'puntuacion' => 'required|integer|between:1,5',
            'comentario' => 'required|string|max:400',
        ]);

        \App\Models\Resena::create([
            'usuario_id' => auth()->id(),
            'producto_id' => $request->producto_id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', '¡Gracias por tu reseña!');
    }

}
