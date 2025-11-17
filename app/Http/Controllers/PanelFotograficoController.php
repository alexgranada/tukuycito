<?php

namespace App\Http\Controllers;

use App\Models\PanelFoto;
use App\Models\PanelFotografico;
use App\Models\PanelFotos;
use App\Models\Producto; // Necesitamos los productos para el formulario
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image; // Importar Intervention Image
use Illuminate\Support\Facades\Log; // Para depuración

class PanelFotograficoController extends Controller
{
    // Directorio de almacenamiento
    private $storageDir = 'panelfotografico';

    /**
     * Muestra la lista de paneles fotográficos.
     */
    public function index(Request $request)
    {
        // Lógica de búsqueda (puedes adaptarla como en tu vista de Obras)
        $query = PanelFotografico::with('usuario', 'producto');

        if ($request->filled('n_guia')) {
            $query->where('n_guia', 'like', '%' . $request->input('n_guia') . '%');
        }
        if ($request->filled('placa')) {
            $query->where('placa', 'like', '%' . $request->input('placa') . '%');
        }
        if ($request->filled('oc')) {
            $query->where('oc', 'like', '%' . $request->input('oc') . '%');
        }

        $paneles = $query->orderBy('fecha', 'desc')->paginate(10);
        
        // Productos para el modal de creación
        $productos = Producto::orderBy('nombre')->get();

        return view('panelfotos', compact('paneles', 'productos'));
    }

    /**
     * Almacena un nuevo panel fotográfico.
     */
    public function store(Request $request)
    {
        // 1. Validación de datos principales
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'n_guia' => 'nullable|string|max:255',
            'precinto' => 'nullable|string|max:255',
            'placa' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'oc' => 'nullable|string|max:255',
            'producto_id' => 'nullable|exists:productos,id',
            'ubicacion' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
            'fotos' => 'required|array|min:1', // Al menos una foto
            'fotos.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240', // 10MB max por foto
        ]);

        if ($validator->fails()) {
            // Guardar errores en la sesión para mostrarlos en el modal
            return redirect()->route('paneles-fotograficos.index')
                ->withErrors($validator, 'create_panel') // Usamos un 'named error bag'
                ->withInput()
                ->with('open_modal', 'modalNuevoPanel'); // Indicamos a la vista que abra este modal
        }
        
        // 2. Validación de cantidad de fotos (Máximo 4)
        if (count($request->file('fotos')) > 4) {
             return redirect()->route('paneles-fotograficos.index')
                ->with('error', 'No puedes subir más de 4 fotos a la vez.')
                ->withInput()
                ->with('open_modal', 'modalNuevoPanel');
        }

        try {
            // 3. Crear el Panel Fotográfico
            $panel = PanelFotografico::create($request->except('fotos') + [
                'usuario_id' => Auth::id(),
                'estado' => 'activo', // O el estado por defecto
            ]);

            // 4. Procesar y guardar fotos
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $file) {
                    
                    // Generar nombre único
                    $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    
                    // Comprimir y guardar la imagen
                    $image = Image::read($file);
                    
                    // Redimensionar si es muy grande (ej. max 1200px de ancho)
                    $image->scaleDown(width: 1200);

                    // --- INICIO DE CAMBIOS ---
                    // Ruta relativa para la base de datos
                    $storagePath = $this->storageDir . '/' . $filename;
                    // Ruta absoluta del servidor para guardar el archivo
                    $fullPath = storage_path('app/public/' . $storagePath);

                    // Asegurarse de que el directorio exista
                    $directory = dirname($fullPath);
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    // Guardar la imagen comprimida directamente en el path
                    $image->save($fullPath, quality: 80);
                    // --- FIN DE CAMBIOS ---


                    // 5. Crear el registro en PanelFoto
                    PanelFotos::create([
                        'panelfotografico_id' => $panel->id,
                        'foto' => $storagePath, // Guardamos la ruta relativa al disco 'public'
                        'fecha' => $request->input('fecha'),
                        'usuario_id' => Auth::id(),
                        'descripcion' => 'Foto de panel', // Puedes añadir un campo para esto
                    ]);
                }
            }

            return redirect()->route('paneles-fotograficos.index')->with('success', 'Panel Fotográfico registrado con éxito.');

        } catch (\Exception $e) {
            Log::error("Error al guardar panel: " . $e->getMessage());
            return redirect()->route('paneles-fotograficos.index')->with('error', 'Ocurrió un error al registrar el panel: ' . $e->getMessage());
        }
    }


    /**
     * Actualiza un panel fotográfico existente.
     */
    public function update(Request $request, PanelFotografico $panel)
    {
        // 1. Validación (similar al store, pero adaptada)
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'n_guia' => 'nullable|string|max:255',
            'precinto' => 'nullable|string|max:255',
            'placa' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'oc' => 'nullable|string|max:255',
            'producto_id' => 'nullable|exists:productos,id',
            'ubicacion' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
            'fotos_nuevas' => 'nullable|array', // Las nuevas fotos son opcionales
            'fotos_nuevas.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240', // 10MB
        ]);

         if ($validator->fails()) {
            return redirect()->route('paneles-fotograficos.index')
                ->withErrors($validator, 'edit_panel_' . $panel->id) // Error bag único por panel
                ->withInput()
                ->with('open_modal', 'modalEditPanel-' . $panel->id);
        }

        // 2. Validación de cantidad (Nuevas + Existentes <= 4)
        $fotosActualesCount = $panel->fotos()->count();
        $fotosNuevasCount = $request->hasFile('fotos_nuevas') ? count($request->file('fotos_nuevas')) : 0;

        if (($fotosActualesCount + $fotosNuevasCount) > 4) {
             return redirect()->route('paneles-fotograficos.index')
                ->with('error', "Límite excedido. Ya tienes {$fotosActualesCount} fotos, solo puedes añadir " . (4 - $fotosActualesCount) . " más.")
                ->with('open_modal', 'modalEditPanel-' . $panel->id);
        }

        try {
            // 3. Actualizar datos del panel
            $panel->update($request->except(['fotos_nuevas', '_token', '_method']));

            // 4. Procesar y guardar NUEVAS fotos
            if ($request->hasFile('fotos_nuevas')) {
                foreach ($request->file('fotos_nuevas') as $file) {
                    
                    $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $image = Image::read($file);
                    $image->scaleDown(width: 1200);

                    // --- INICIO DE CAMBIOS ---
                    // Ruta relativa para la base de datos
                    $storagePath = $this->storageDir . '/' . $filename;
                    // Ruta absoluta del servidor para guardar el archivo
                    $fullPath = storage_path('app/public/' . $storagePath);

                    // Asegurarse de que el directorio exista
                    $directory = dirname($fullPath);
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    // Guardar la imagen comprimida directamente en el path
                    $image->save($fullPath, quality: 80);
                    // --- FIN DE CAMBIOS ---

                    PanelFotos::create([
                        'panelfotografico_id' => $panel->id,
                        'foto' => $storagePath,
                        'fecha' => $request->input('fecha'),
                        'usuario_id' => Auth::id(),
                    ]);
                }
            }

            return redirect()->route('paneles-fotograficos.index')->with('success', 'Panel Fotográfico actualizado con éxito.');

        } catch (\Exception $e) {
            Log::error("Error al actualizar panel: " . $e->getMessage());
            return redirect()->route('paneles-fotograficos.index')->with('error', 'Ocurrió un error al actualizar: ' . $e->getMessage());
        }
    }


    /**
     * Elimina un panel fotográfico (y sus fotos asociadas).
     */
    public function destroy(PanelFotografico $panel)
    {
        try {
            // 1. Eliminar fotos del storage
            foreach ($panel->fotos as $foto) {
                if (Storage::disk('public')->exists($foto->foto)) {
                    Storage::disk('public')->delete($foto->foto);
                }
                // La foto en DB se borra por la restricción de la BD (ON DELETE CASCADE)
                // Si no tuvieras 'ON DELETE CASCADE', deberías borrarlas manualmente: $foto->delete();
            }

            // 2. Eliminar el panel
            // (La tabla panel_fotos tiene ON DELETE CASCADE, se borrarán en cascada)
            $panel->delete();

            return redirect()->route('paneles-fotograficos.index')->with('success', 'Panel Fotográfico eliminado con éxito.');
        } catch (\Exception $e) {
            Log::error("Error al eliminar panel: " . $e->getMessage());
            return redirect()->route('paneles-fotograficos.index')->with('error', 'Ocurrió un error al eliminar el panel. Es posible que tenga registros asociados.');
        }
    }

    /**
     * Devuelve las fotos de un panel en formato JSON.
     */
    public function getFotosJson(PanelFotografico $panel)
    {
        // Cargamos las fotos y les añadimos la URL pública
        $fotos = $panel->fotos->map(function ($foto) {
            $foto->url = Storage::disk('public')->url($foto->foto);
            return $foto;
        });
        
        return response()->json($fotos);
    }

    /**
     * Elimina una foto individual (usado en el modal de edición).
     */
    public function eliminarFotoIndividual(PanelFotos $foto)
    {
        // Opcional: Verificar permisos (que el usuario sea admin o el dueño)
        // if(Auth::id() !== $foto->usuario_id && !Auth::user()->esAdmin()) {
        //     return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        // }

        try {
            // 1. Eliminar del storage
            if (Storage::disk('public')->exists($foto->foto)) {
                Storage::disk('public')->delete($foto->foto);
            }
            
            // 2. Eliminar de la BD
            $foto->delete();

            return response()->json(['success' => true, 'message' => 'Foto eliminada.']);

        } catch (\Exception $e) {
            Log::error("Error al eliminar foto individual: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al eliminar la foto.'], 500);
        }
    }

    public function generarPDF(PanelFotografico $panel)
    {
        try {
            // Cargamos las relaciones necesarias
            $panel->load('fotos', 'producto');
            
            // Pasamos los datos del panel a la vista del PDF
            $data = compact('panel');
            
            // Generamos el PDF
            $pdf = Pdf::loadView('paneles-fotograficos.pdf', $data);

            // Opcional: Configurar el papel y orientación
            // $pdf->setPaper('a4', 'portrait'); // portrait (vertical) o landscape (horizontal)

            // Devolver el PDF al navegador
            return $pdf->stream('reporte-panel-' . $panel->id . '.pdf');

        } catch (\Exception $e) {
            Log::error("Error al generar PDF del panel {$panel->id}: " . $e->getMessage());
            return redirect()->route('paneles-fotograficos.index')
                             ->with('error', 'No se pudo generar el PDF: ' . $e->getMessage());
        }
    }
}