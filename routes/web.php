<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/', [AuthController::class, 'validar'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');
});