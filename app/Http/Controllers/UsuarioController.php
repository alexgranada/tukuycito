<?php

namespace App\Http\Controllers;

use App\Models\User; // O App\User, dependiendo de tu namespace
use App\Models\Almacen; // Necesario para los selectores
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Para encriptar
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('almacen');

        // Lógica de Búsqueda
        if ($request->filled('nombre')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombres', 'like', '%' . $request->input('nombre') . '%')
                    ->orWhere('apellidos', 'like', '%' . $request->input('nombre') . '%');
            });
        }
        if ($request->filled('dni')) {
            $query->where('dni', 'like', '%' . $request->input('dni') . '%');
        }
        if ($request->filled('correo')) {
            $query->where('correo', 'like', '%' . $request->input('correo') . '%');
        }
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        $usuarios = $query->orderBy('nombres')->paginate(10);

        // Obtenemos almacenes para los modales
        $almacenes = Almacen::orderBy('nombre')->get();

        // Tipos de usuario definidos
        $tiposUsuario = ['admin', 'almacen', 'user', 'reportes'];

        return view('usuarios', compact('usuarios', 'almacenes', 'tiposUsuario'));
    }

    /**
     * Almacena un nuevo usuario.
     */
    public function store(Request $request)
    {
        // 1. Validación
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|max:15|unique:users,dni',
            'correo' => 'required|string|email|max:255|unique:users,correo',
            'telefono' => 'nullable|string|max:20',
            'almacen_id' => 'required|exists:almacens,id',
            'tipo' => 'required|string|in:admin,almacen,user,reportes',
            'clave' => 'required|string|min:8|confirmed', // 'confirmed' busca 'clave_confirmation'
        ]);

        if ($validator->fails()) {
            return redirect()->route('usuarios.index')
                ->withErrors($validator, 'create_usuario')
                ->withInput()
                ->with('open_modal', 'modalNuevoUsuario');
        }

        // 2. Creación
        try {
            User::create([
                'nombres' => $request->input('nombres'),
                'apellidos' => $request->input('apellidos'),
                'dni' => $request->input('dni'),
                'correo' => $request->input('correo'),
                'telefono' => $request->input('telefono'),
                'almacen_id' => $request->input('almacen_id'),
                'tipo' => $request->input('tipo'),
                'clave' => Hash::make($request->input('clave')), // Encriptar
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario registrado con éxito.');
        } catch (\Exception $e) {
            Log::error("Error al guardar usuario: " . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Ocurrió un error al registrar el usuario.');
        }
    }


    /**
     * Actualiza un usuario existente.
     */
    public function update(Request $request, User $usuario)
    {
        // 1. Validación
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => [
                'required',
                'string',
                'max:15',
                Rule::unique('users')->ignore($usuario->id), // Ignorar al usuario actual
            ],
            'correo' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($usuario->id), // Ignorar al usuario actual
            ],
            'telefono' => 'nullable|string|max:20',
            'almacen_id' => 'required|exists:almacens,id',
            'tipo' => 'required|string|in:admin,almacen,user,reportes',
            'clave' => 'nullable|string|min:8|confirmed', // La clave es opcional en la actualización
        ]);

        if ($validator->fails()) {
            return redirect()->route('usuarios.index')
                ->withErrors($validator, 'edit_usuario_' . $usuario->id)
                ->withInput()
                ->with('open_modal', 'modalEditUsuario-' . $usuario->id);
        }

        // 2. Actualización
        try {
            // Preparar datos
            $data = $request->except(['clave', 'clave_confirmation', '_token', '_method']);

            // Si el campo 'clave' está lleno, lo actualizamos
            if ($request->filled('clave')) {
                $data['clave'] = Hash::make($request->input('clave'));
            }

            $usuario->update($data);

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado con éxito.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar usuario: " . $e->getMessage());
            return redirect()->route('usuarios.index')->with('error', 'Ocurrió un error al actualizar el usuario.');
        }
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $usuario)
    {
        // 1. Evitar que un usuario se elimine a sí mismo
        if ($usuario->id === Auth::id()) {
            return redirect()->route('usuarios.index')->with('error', 'No puedes eliminar tu propia cuenta de usuario.');
        }

        try {
            $usuario->delete();
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado con éxito.');
        } catch (\Exception $e) {
            Log::error("Error al eliminar usuario: " . $e->getMessage());
            // Error común: Llave foránea (si el usuario tiene préstamos, etc.)
            return redirect()->route('usuarios.index')->with('error', 'No se pudo eliminar el usuario. Es posible que tenga registros asociados (paneles, préstamos, etc.).');
        }
    }
}
