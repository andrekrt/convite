<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Gift;
use App\Models\Transaction;

class PaymentService
{
    private string $token;

    public function __construct()
    {
        $this->token = config('services.mercadopago.token') ?? '';
    }

    public function createPixPayment(Gift $gift, $guestName)
    {
        // Geramos um ID único para esta tentativa de pagamento
        $idempotencyKey = \Illuminate\Support\Str::uuid()->toString();

        $response = Http::withToken($this->token)
            ->withHeaders([
                'X-Idempotency-Key' => $idempotencyKey
            ])
            ->withoutVerifying()
            ->post('https://api.mercadopago.com/v1/payments', [
                "transaction_amount" => (float) $gift->price,
                "description" => "Presente: " . $gift->title,
                "payment_method_id" => "pix",
                "payer" => [
                    "email" => "convidado_" . time() . "@teste.com",
                    "first_name" => $guestName,
                    "identification" => [
                        "type" => "CPF",
                        "number" => "19119119100"
                    ]
                ],
                "installments" => 1
            ]);

        $data = $response->json();

        if ($response->failed()) {
            Log::error("Erro Mercado Pago API:", $data ?? []);
            throw new \Exception("Falha na API: " . ($data['message'] ?? 'Erro desconhecido'));
        }

        // Retorno da Transaction (conforme código anterior)...
        return Transaction::create([
            'gift_id' => $gift->id,
            'payer_name' => $guestName,
            'amount' => $gift->price,
            'status' => 'pending',
            'payment_gateway_id' => (string) $data['id'],
            'pix_code' => $data['point_of_interaction']['transaction_data']['qr_code'],
        ]);
    }
}
