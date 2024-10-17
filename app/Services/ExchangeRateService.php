<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.exchangerate-api.com/v4/latest/';

    public function __construct()
    {
        $this->apiKey = config('services.exchange_rate.api_key');
    }

    public function getRate($from, $to)
    {
        $response = Http::get($this->baseUrl . $from);

        if ($response->successful()) {
            $data = $response->json();
            return $data['rates'][$to] ?? null;
        }

        return null;
    }
}