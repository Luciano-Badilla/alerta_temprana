<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GestAlertsController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\ExamenController;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

///////////////////////////

Route::get('', [GestAlertsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('alerts');

Route::get('/alerts', [GestAlertsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('alerts');

// routes/web.php
Route::post('/get-personal-data', [AlertController::class, 'getPersonalDataByDNI'])->name('get_data');

Route::post('/get-personal-data-local', [AlertController::class, 'getPersonalDataLocalByDNI'])->name('get_data_local');

Route::post('/get-personal-data-local-empty-inputs', [AlertController::class, 'getPersonalDataLocalEmptyInputsByDNI'])->name('get_data_local_empty_inputs');

Route::get('', function () {
    return view('auth/login');
})->name('profile_view');

Route::get('/alerts/create_alert', [AlertController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('alert.create');

Route::post('/alerts/create_alert', [AlertController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('alert.store');

Route::post('/alerts/create_alert2', [AlertController::class, 'store2'])
    ->middleware(['auth', 'verified'])
    ->name('alert.store2');

Route::get('/alerts/edit_alert/{id}', [AlertController::class, 'edit_index'])
    ->middleware(['auth', 'verified'])
    ->name('alert.edit');

Route::post('/alerts/edit_store_alert', [AlertController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('alert.edit_store');

Route::get('/alerts/gest_alert/{id}', [AlertController::class, 'gest_index'])
    ->middleware(['auth', 'verified'])
    ->name('alert.gest');

Route::post('/alerts/gest_alert', [AlertController::class, 'completed'])
    ->middleware(['auth', 'verified'])
    ->name('alert.completed');

Route::post('/estado/agregar', [AlertController::class, 'agregarEstado'])->name('estado.agregar');
Route::post('/estado/eliminar', [AlertController::class, 'eliminarEstado'])->name('estado.eliminar');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/especialidades/create_especialidad', [EspecialidadController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('especialidad.create');

Route::post('/especialidades/create_especialidad', [EspecialidadController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('especialidad.store');

Route::post('/examenes/create_examen', [ExamenController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('examen.store');
Route::post('/examenes/alter_examen', [ExamenController::class, 'alter_borrado_logico'])
    ->middleware(['auth', 'verified'])
    ->name('examen.alter');

Route::post('/especialidades/edit_specialty', [EspecialidadController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->name('especialidad.edit');

Route::post('/especialidades/delete_specialty', [EspecialidadController::class, 'delete'])
    ->middleware(['auth', 'verified'])
    ->name('especialidad.delete');

require __DIR__ . '/auth.php';
