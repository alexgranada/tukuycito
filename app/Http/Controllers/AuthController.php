<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // <-- Necesario para verificar la existencia del DNI antes de Auth::attempt

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    /**
     * Login de usuario
     */
    public function validar(Request $request)
    {
        $request->validate([
            'dni' => 'required|string',
            'password' => 'required|string',
        ]);

        $dni = $request->dni;
        $password = $request->password;

        // 1. Buscamos al usuario solo por DNI.
        // Esto permite diferenciar si la falla es por DNI no existente o por clave incorrecta.
        // NOTA: Se asume que tienes un modelo User configurado en App\Models\User y la columna 'dni'.
        $user = User::where('dni', $dni)->first(); 
        
        if (!$user) {
            // Caso 2: Usuario NO registrado / DNI no encontrado
            return back()->withErrors([
                'not_registered' => 'No tienes acceso al sistema, comuniquese con el ingeniero de sistemas :-)',
            ])->onlyInput('dni');
        }

        // 2. Si el usuario existe, intentamos la autenticación completa.
        $credentials = [
            'dni' => $dni,
            'password' => $password,
        ];
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // Caso 1: DNI existe, pero la clave es incorrecta
        return back()->withErrors([
            'dni' => 'Las credenciales ingresadas no son válidas.', // Mensaje más adecuado
        ])->onlyInput('dni');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirigir a la página de inicio o login
        return redirect('/');
    }
}