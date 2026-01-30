<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Gift $gift, PaymentService $paymentService)
    {
        $guestName = $request->input('guest_name', 'Convidado');

        try {
            $transaction = $paymentService->createPixPayment($gift, $guestName);

            return response()->json([
                'pix_code' => $transaction->pix_code,
                'qr_code_base64'=>$transaction->qr_code_base64,
                'amount' => number_format($transaction->amount, 2, ',', '.')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}
