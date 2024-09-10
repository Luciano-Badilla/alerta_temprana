<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GestAlertsController;
use App\Http\Controllers\AlertController;
use Illuminate\Support\Facades\Route;

///////////////////////////

Route::get('', [GestAlertsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest.alerts');

Route::get('/gest_alerts', [GestAlertsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('gest.alerts');

// routes/web.php
Route::post('/get-personal-data', [AlertController::class, 'getPersonalDataByDNI'])->name('get_data');

Route::post('/get-personal-data-local', [AlertController::class, 'getPersonalDataLocalByDNI'])->name('get_data_local');

Route::post('/get-personal-data-local-empty-inputs', [AlertController::class, 'getPersonalDataLocalEmptyInputsByDNI'])->name('get_data_local_empty_inputs');

Route::get('', function () {
    return view('auth/login');
})->name('profile_view');

Route::get('/gest_alerts/create_alert', [AlertController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('alert.create');

Route::post('/gest_alerts/create_alert', [AlertController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('alert.store');

Route::post('/gest_alerts/create_alert2', [AlertController::class, 'store2'])
    ->middleware(['auth', 'verified'])
    ->name('alert.store2');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
