<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Services\LencoService;

class WebhookController extends Controller
{
    protected $lencoService;

    public function __construct(LencoService $lencoService)
    {
        $this->lencoService = $lencoService;
    }

    public function handleCoinRemitter(Request $request)
    {
        // Verify the webhook signature
        if (!$this->verifyCoinRemitterSignature($request)) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $transactionId = $request->input('custom_order_id');
        $status = $request->input('status');

        $transaction = Transaction::findOrFail($transactionId);

        if ($status === 'paid') {
            $transaction->update(['status' => 'processing']);

            // Initiate bank transfer
            $transferResult = $this->lencoService->initiateTransfer(
                $transaction->naira_amount,
                $transaction->user->bank_account,
                $transaction->user->bank_code
            );

            if ($transferResult) {
                $transaction->update(['status' => 'completed']);
            } else {
                $transaction->update(['status' => 'failed']);
            }
        } elseif ($status === 'failed') {
            $transaction->update(['status' => 'failed']);
        }

        return response()->json(['success' => true]);
    }

    private function verifyCoinRemitterSignature(Request $request)
    {
        // Implement signature verification logic
        return true;
    }
}