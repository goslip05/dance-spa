<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\ClassController;
use App\Http\Controllers\Client\AppointmentController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Controllers\Professional\AgendaController;
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

// Rutas para Clientes
Route::middleware(['auth'])->prefix('client')->name('client.')->group(function () {
    // Clases de Baile
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::post('/classes/{schedule}/enroll', [ClassController::class, 'enroll'])->name('classes.enroll');
    Route::get('/my-classes', [ClassController::class, 'myClasses'])->name('classes.my-classes');

    // Citas de Spa
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create/{service}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.my-appointments');

    // Tienda
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/my-orders', [ShopController::class, 'myOrders'])->name('shop.my-orders');
});

// Rutas para Profesionales
Route::middleware(['auth', 'role:Profesional'])->prefix('professional')->name('professional.')->group(function () {
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::post('/agenda/complete/{appointment}', [AgendaController::class, 'complete'])->name('agenda.complete');
});

require __DIR__.'/auth.php';
