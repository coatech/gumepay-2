<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CoinRemitterService;

class WalletController extends Controller
{
    protected $coinRemitterService;

    public function __construct(CoinRemitterService $coinRemitterService)
    {
        $this->coinRemitterService = $coinRemitterService;
    }

    public function index()
    {
        $wallets = $this->coinRemitterService->getWallets();
        return view('wallet', compact('wallets'));
    }

    public function connect(Request $request)
    {
        $validated = $request->validate([
            'wallet_address' => 'required|string',
            'currency' => 'required|string',
        ]);

        $result = $this->coinRemitterService->connectWallet($validated['wallet_address'], $validated['currency']);

        if ($result) {
            return redirect()->route('wallet')->with('success', 'Wallet connected successfully');
        } else {
            return back()->with('error', 'Failed to connect wallet');
        }
    }
}