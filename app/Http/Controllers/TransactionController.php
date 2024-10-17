<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CoinRemitterService;
use App\Services\LencoService;
use App\Services\ExchangeRateService;
use App\Models\Transaction;

class TransactionController extends Controller
{
    protected $coinRemitterService;
    protected $lencoService;
    protected $exchangeRateService;

    public function __construct(CoinRemitterService $coinRemitterService, LencoService $lencoService, ExchangeRateService $exchangeRateService)
    {
        $this->coinRemitterService = $coinRemitterService;
        $this->lencoService = $lencoService;
        $this->exchangeRateService = $exchangeRateService;
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string',
            'bank_account' => 'required|string',
        ]);

        // Get real-time exchange rate
        $exchangeRate = $this->exchangeRateService->getRate($validated['currency'], 'NGN');
        $nairaAmount = $validated['amount'] * $exchangeRate;

        // Start the transaction
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'naira_amount' => $nairaAmount,
            'exchange_rate' => $exchangeRate,
            'status' => 'pending',
        ]);

        // Initiate crypto payment
        $paymentResult = $this->coinRemitterService->initiatePayment($transaction->id, $validated['amount'], $validated['currency']);

        if ($paymentResult) {
            return redirect()->route('transactions.show', $transaction->id)->with('success', 'Transaction initiated. Please complete the payment.');
        } else {
            $transaction->update(['status' => 'failed']);
            return back()->with('error', 'Failed to initiate transaction');
        }
    }
}