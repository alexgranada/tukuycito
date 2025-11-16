<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos con filtros y paginación.
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        // Aplicar filtros de búsqueda
        if ($request->filled('codigo')) {
            $query->where('codigo', 'like', '%' . $request->codigo . '%');
        }

        if ($request->filled('nombre')) {
            // Usamos 'nombre' que en la vista llamamos 'Descripción'
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Obtener tipos únicos para el dropdown de filtro
        // Nos aseguramos de filtrar valores nulos o vacíos
        $tipos = Producto::select('tipo')
            ->whereNotNull('tipo')
            ->where('tipo', '!=', '')
            ->distinct()
            ->pluck('tipo');

        // Paginamos los resultados y mantenemos los filtros en la URL
        $productos = $query->orderBy('nombre', 'asc')->paginate(15)->appends($request->all());

        return view('productos', compact('productos', 'tipos'));
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:520',
            'codigo' => 'required|string|max:255|unique:productos,codigo',
            'tipo' => 'nullable|string|max:255',
            'uni_medida' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB Max
            'form_type' => 'required|string', // Campo oculto para identificar el formulario
        ]);

        if ($validator->fails()) {
            return redirect()->route('productos.index')
                ->withErrors($validator)
                ->withInput(); // Vuelve con los errores y los datos antiguos
        }

        $validatedData = $validator->validated();
        $path = null;

        // Manejo de subida de foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('productos', 'public');
            $validatedData['foto'] = $path;
        }

        Producto::create($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto registrado exitosamente.');
    }

    /**
     * Actualiza un producto existente.
     */
    public function update(Request $request, Producto $producto)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:520',
            'codigo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('productos')->ignore($producto->id), // Ignora el ID actual al verificar unicidad
            ],
            'tipo' => 'nullable|string|max:255',
            'uni_medida' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'form_type' => 'required|string', // Campo oculto
        ]);

        if ($validator->fails()) {
            return redirect()->route('productos.index')
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();
        $path = $producto->foto; // Mantenemos la foto existente por defecto

        // Manejo de actualización de foto
        if ($request->hasFile('foto')) {
            // Si hay una foto nueva, eliminamos la anterior (si existe)
            if ($producto->foto) {
                Storage::disk('public')->delete($producto->foto);
            }
            // Almacenamos la nueva foto
            $path = $request->file('foto')->store('productos', 'public');
            $validatedData['foto'] = $path;
        }

        $producto->update($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina un producto.
     */
    public function destroy(Producto $producto)
    {
        try {
            // Eliminar la foto asociada si existe
            if ($producto->foto) {
                Storage::disk('public')->delete($producto->foto);
            }

            $producto->delete();

            return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores (ej. restricción de clave foránea)
            // --- ACTUALIZACIÓN: Captura específica de QueryException ---
            if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() == '23000') {
                 return redirect()->route('productos.index')->with('error', 'No se pudo eliminar el producto. Está siendo usado en uno o más préstamos.');
            }
            return redirect()->route('productos.index')->with('error', 'No se pudo eliminar el producto: ' . $e->getMessage());
        }
    }

    /**
     * Busca productos para el selector AJAX.
     */
    public function buscar(Request $request)
    {
        $term = $request->input('term', '');
        
        if (empty($term)) {
            return response()->json([]);
        }

        $productos = Producto::where('nombre', 'like', "%{$term}%")
                             ->orWhere('codigo', 'like', "%{$term}%")
                             ->select('id', 'nombre', 'codigo', 'foto', 'uni_medida')
                             ->limit(10) // Limitar resultados para performance
                             ->get();
                             
        // Preparar datos para el frontend (ej. añadir URL de foto)
        $productos->each(function($producto) {
            $producto->foto_url = $producto->foto 
                ? Storage::url($producto->foto) 
                : 'https://placehold.co/60x60/eee/ccc?text=Sin+Foto';
        });

        return response()->json($productos);
    }

    /**
     * Almacena un nuevo producto rápidamente (vía AJAX).
     */
    public function storeRapido(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:520',
            'codigo' => 'required|string|max:255|unique:productos,codigo',
            'uni_medida' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $producto = Producto::create($validator->validated());
        
        // Preparar el producto con la URL de la foto para el JS
        $producto->foto_url = 'https://placehold.co/60x60/eee/ccc?text=Sin+Foto'; // Foto por defecto
        
        // Retornar el producto recién creado para que JS lo pueda usar
        return response()->json($producto, 201);
    }
}