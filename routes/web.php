<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/convite/{code}', [InvitationController::class, 'show'])->name('invitation.show');
Route::post('/convite/{code}/confirmar', [InvitationController::class, 'confirm'])->name('invitation.confirm');
Route::post('/pagamento/pix/{gift}', [PaymentController::class, 'store'])->name('payment.pix');
