<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
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
        ], [
            'nombre_usuario.required' => 'Debes introducir un nombre de usuario.',
            'nombre_usuario.unique' => 'Este nombre de usuario ya está en uso.',

            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Introduce un correo electrónico válido.',
            'correo.unique' => 'Este correo ya está registrado.',

            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.min' => 'La contraseña debe tener al menos 4 caracteres.',

            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
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

        // Obtenemos los pedidos del usuario con su factura asociada
        $pedidos = Pedido::with('factura') // si quieres mostrar detalles de factura
        ->where('usuario_id', $usuario->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('perfil', compact('usuario', 'pedidos'));
    }

    public function funcionEliminarUsuario(Request $request)
    {
        $usuarioId = $request->input('usuario_id');

        // Evitar que un admin se elimine a sí mismo (opcional pero recomendable)
        if (auth()->id() == $usuarioId) {
            return redirect()->route('eliminarUsuario')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            $usuario->delete();

            return redirect()->route('eliminarUsuario')
                ->with('success', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->route('eliminarUsuario')
                ->with('error', 'El usuario no fue encontrado.');
        }
    }


    public function funcionHacerAdmin(Request $request)
    {
        $usuarioId = $request->input('usuario_id');

        // Evitar convertirte a ti mismo si ya eres admin (opcional)
        if (auth()->id() == $usuarioId) {
            return redirect()->route('hacerAdmin')->with('error', 'Ya eres administrador.');
        }

        $usuario = Usuario::find($usuarioId);

        if ($usuario) {
            // Solo actualiza si no es ya admin
            if (!$usuario->es_admin) {
                $usuario->es_admin = 1;
                $usuario->save();

                return redirect()->route('hacerAdmin')->with('success', 'El usuario ahora es administrador.');
            } else {
                return redirect()->route('hacerAdmin')->with('error', 'Ese usuario ya es administrador.');
            }
        } else {
            return redirect()->route('hacerAdmin')->with('error', 'Usuario no encontrado.');
        }
    }

    public function usuarioCerrarSesion(Request $request)
    {
        Auth::logout();
        session()->forget('carrito'); // Limpia el carrito
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/login");
    }


}
