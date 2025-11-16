<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevengadoController;
use App\Http\Controllers\ObraController;
use App\Http\Controllers\PanelFotograficoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ProductoController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'validar'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
     Route::get('devengados', [DevengadoController::class, 'index'])->name('devengados.index');
     Route::post('devengados', [DevengadoController::class, 'store'])->name('devengados.store');
     Route::put('/devengados/{devengado}', [DevengadoController::class, 'update'])->name('devengados.update');
     Route::post('/devengados/{devengado}/anular', [DevengadoController::class, 'anular'])->name('devengados.anular');

     /* panel fotografico */
     Route::get('/panel-fotografico', [PanelFotograficoController::class, 'index'])->name('panel.index');
     Route::post('/panel-fotografico/upload', [PanelFotograficoController::class, 'upload'])->name('panel.upload');
     Route::delete('/panel-fotografico/{foto}', [PanelFotograficoController::class, 'destroy'])->name('panel.destroy');

     /* productos */
     Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
     Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
     Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
     Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
     Route::get('/productos/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');
     Route::post('/productos/store-rapido', [ProductoController::class, 'storeRapido'])->name('productos.storeRapido');


     /* obras */
     Route::resource('obras', ObraController::class);

     /* prestamos */
     Route::resource('prestamos', PrestamoController::class);
     Route::get('/prestamos/{prestamo}/detalles', [PrestamoController::class, 'getDetalles'])->name('prestamos.getDetalles');

     /* fotos */
     Route::resource('paneles-fotograficos', PanelFotograficoController::class);

     // Ruta adicional para obtener las fotos de un panel (para el modal "Ver Fotos")
     Route::get('paneles-fotograficos/{panel}/fotos', [PanelFotograficoController::class, 'getFotosJson'])->name('paneles.getFotos');

     // Ruta para eliminar una foto individual
     Route::delete('panel-fotos/{foto}', [PanelFotograficoController::class, 'eliminarFotoIndividual'])->name('paneles.fotos.destroy');
});
