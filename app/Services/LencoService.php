<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LencoService
{
    protected $apiKey;
    protected $secretKey;
    protected $baseUrl = 'https://api.lenco.ng/v1/';

    public function __construct()
    {
        $this->apiKey = config('services.lenco.api_key');
        $this->secretKey = config('services.lenco.secret_key');
    }

    public function initiateTransfer($amount, $accountNumber, $bankCode)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUrl . 'transfers', [
            'amount' => $amount,
            'account_number' => $accountNumber,
            'bank_code' => $bankCode,
            'currency' => 'NGN',
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return null;
    }
}