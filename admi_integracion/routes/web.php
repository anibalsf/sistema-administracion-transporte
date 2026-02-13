<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AfiliadoController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\HojaRutaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SancionController;
use App\Http\Controllers\AsistenciaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource routes
    Route::resource('afiliados', AfiliadoController::class);
    Route::resource('vehiculos', VehiculoController::class);
    Route::resource('rutas', RutaController::class);
    Route::resource('hojas-ruta', HojaRutaController::class);
    Route::resource('pagos', PagoController::class);
    Route::resource('reservas', ReservaController::class);
    Route::resource('sanciones', SancionController::class);
    Route::resource('asistencias', AsistenciaController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
