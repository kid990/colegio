<?php

use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\PeriodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
 Route::resource('/configuracion', ConfiguracionController::class);
 Route::post('/config', [ConfiguracionController::class, 'store'])->name('config.store');
 Route::resource('/gestion', GestionController::class);
 Route::resource('/nivel', NivelController::class);
 Route::resource('/turno', TurnoController::class);
 Route::resource('/periodo', PeriodoController::class);
});

require __DIR__.'/auth.php';
