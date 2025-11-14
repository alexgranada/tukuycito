<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $credentials = [
            'dni' => $request->dni,
            'password' => $request->password, // SIEMPRE usando 'password' aquí
        ];

        // Intenta autenticar
        if (Auth::attempt($credentials, $request->filled('remember'))) {

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'dni' => 'Las credenciales proporcionadas (DNI o Clave) no coinciden con nuestros registros.',
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
