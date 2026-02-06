<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GiftController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



// Rotas do convite
Route::get('/convite/{code}',[InvitationController::class, 'show'])->name('invitation.show');
Route::post('/convite/{code}/confirmar', [InvitationController::class, 'confirm'])->name('invitation.confirm');

// Rotas do presente
Route::post('/pagamento/pix/{gift}', [PaymentController::class, 'store'])->name('payment.pix');

// Rotas de gerenciamento interno
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard principal do Breeze
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestão de Convidados
    Route::get('/convidados', [GuestController::class, 'index'])->name('guests.index');
    Route::get('/convidados/novo', [GuestController::class, 'create'])->name('guests.create');
    Route::post('/convidados', [GuestController::class, 'store'])->name('guests.store');
    Route::get('/convidados/{guest}/editar', [GuestController::class, 'edit'])->name('guests.edit');
    Route::put('/convidados/{guest}', [GuestController::class, 'update'])->name('guests.update');
    Route::delete('/convidados/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');

    // Rotas dos Presentes
    Route::get('/presentes', [GiftController::class, 'index'])->name('gifts.index');
    Route::get('/presentes/novo', [GiftController::class, 'create'])->name('gifts.create');
    Route::post('/presentes', [GiftController::class, 'store'])->name('gifts.store');
    Route::get('/presentes/{gift}/editar', [GiftController::class, 'edit'])->name('gifts.edit');
    Route::put('/presentes/{gift}', [GiftController::class, 'update'])->name('gifts.update');
    Route::delete('/presentes/{gift}', [GiftController::class, 'destroy'])->name('gifts.destroy');

    // Rotas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
