<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class UsuarioController extends Controller
{

    public function mostrarLogin()
    {
        if (auth()->check()) {
            return redirect()->route('productos.vista');
        }

        return view('login');
    }



    public function create(Request $request)
    {
        // Validación opcional
        $request->validate([
            'nombre_usuario' => 'required|unique:usuarios,nombre_usuario',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:4',
            'nombre' => 'required',
            'apellidos' => 'required',
        ]);

        $usuario = new Usuario();
        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->correo = $request->correo;
        $usuario->contrasena = Hash::make($request->contrasena);
        $usuario->es_admin = 0;

        $usuario->save();

        return redirect('/login')->with('success', 'Registro completado. Inicia sesión.');
    }

    public function comprobarLogin(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required'
        ]);

        $usuario = Usuario::where('correo', $request->correo)->first();

        if ($usuario && Hash::check($request->contrasena, $usuario->contrasena)) {
            Auth::login($usuario);

            // Redirige siempre a la vista principal
            return redirect()->route('productos.vista');
        } else {
            return back()->withErrors([
                'correo' => 'Credenciales incorrectas.'
            ])->onlyInput('correo');
        }
    }

    public function verPerfil()
    {
        $usuario = auth()->user();
        return view('perfil', compact('usuario'));
    }

}
