<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CoinRemitterService
{
    protected $apiKey;
    protected $password;
    protected $baseUrl = 'https://coinremitter.com/api/v3/';

    public function __construct()
    {
        $this->apiKey = config('services.coinremitter.api_key');
        $this->password = config('services.coinremitter.password');
    }

    public function getWallets()
    {
        $response = Http::post($this->baseUrl . 'get-wallet', [
            'api_key' => $this->apiKey,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return null;
    }

    public function connectWallet($address, $currency)
    {
        $response = Http::post($this->baseUrl . 'add-wallet', [
            'api_key' => $this->apiKey,
            'password' => $this->password,
            'address' => $address,
            'coin' => $currency,
        ]);

        return $response->successful();
    }

    public function initiatePayment($transactionId, $amount, $currency)
    {
        $response = Http::post($this->baseUrl . 'create-invoice', [
            'api_key' => $this->apiKey,
            'password' => $this->password,
            'amount' => $amount,
            'currency' => $currency,
            'custom_order_id' => $transactionId,
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return null;
    }
}