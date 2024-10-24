<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GestAlertsController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\GestionUsers;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserAccess;
use App\Http\Middleware\CheckUserRole;

// Middleware general
Route::middleware(['auth', 'verified', CheckUserAccess::class])->group(function () {
    Route::middleware([CheckUserRole::class . ':1,2,3,4'])->group(function () {
        Route::get('', [GestAlertsController::class, 'index'])->name('alerts');
        Route::get('/alerts', [GestAlertsController::class, 'index'])->name('alerts');
    });

    Route::middleware([CheckUserRole::class . ':2,3,4'])->group(function () {
        Route::get('/alerts/create_alert', [AlertController::class, 'index'])->name('alert.create');
        Route::post('/alerts/create_alert', [AlertController::class, 'store'])->name('alert.store');
        Route::post('/alerts/create_alert2', [AlertController::class, 'store2'])->name('alert.store2');
        Route::get('/alerts/edit_alert/{id}', [AlertController::class, 'edit_index'])->name('alert.edit');
        Route::post('/alerts/edit_store_alert', [AlertController::class, 'edit'])->name('alert.edit_store');
        Route::get('/alerts/gest_alert/{id}', [AlertController::class, 'gest_index'])->name('alert.gest');
        Route::post('/alerts/gest_alert', [AlertController::class, 'completed'])->name('alert.completed');

        Route::get('/generate_pdf/{id}', [PDFController::class, 'generate'])->name('generate.pdf');

        // Rutas relacionadas a estado
        Route::post('/estado/agregar', [AlertController::class, 'agregarEstado'])->name('estado.agregar');
        Route::post('/estado/eliminar', [AlertController::class, 'eliminarEstado'])->name('estado.eliminar');

        // Obtencion de datos
        Route::post('/get-personal-data', [AlertController::class, 'getPersonalDataByDNI'])->name('get_data');
        Route::post('/get-personal-data-local', [AlertController::class, 'getPersonalDataLocalByDNI'])->name('get_data_local');
        Route::post('/get-personal-data-local-empty-inputs', [AlertController::class, 'getPersonalDataLocalEmptyInputsByDNI'])->name('get_data_local_empty_inputs');
    });

    Route::middleware([CheckUserRole::class . ':4'])->group(function () {
        Route::get('/users/users_gest', [GestionUsers::class, 'index'])->name('users.gest');
        Route::post('/usuarios/update/{id}', [GestionUsers::class, 'updateUser'])->name('usuarios.update');
        Route::post('/usuarios/validate/{id}', [GestionUsers::class, 'ValidateUser'])->name('usuarios.validate');
        Route::post('/usuarios/password/{id}', [GestionUsers::class, 'passwordUser'])->name('usuarios.password');

        Route::get('/especialidades/create_especialidad', [EspecialidadController::class, 'index'])->name('especialidad.create');
        Route::post('/especialidades/create_especialidad', [EspecialidadController::class, 'store'])->name('especialidad.store');
        Route::post('/especialidades/edit_specialty', [EspecialidadController::class, 'edit'])->name('especialidad.edit');
        Route::post('/especialidades/delete_specialty', [EspecialidadController::class, 'delete'])->name('especialidad.delete');

        Route::post('/examenes/create_examen', [ExamenController::class, 'store'])->name('examen.store');
        Route::post('/examenes/alter_examen', [ExamenController::class, 'alter_borrado_logico'])->name('examen.alter');
    });

    // Rutas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/usuarios/requestpassword', [GestionUsers::class, 'requestPassword'])->name('usuarios.requestPassword');
Route::get('', function () {
    return view('auth/login');
})->name('profile_view');

Route::get('/unauthorized', function () {
    return view('unauthorized'); // Carga la vista 'unauthorized.blade.php'
})->name('unauthorized');

require __DIR__ . '/auth.php';
