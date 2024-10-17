<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalTransactions', 'recentTransactions'));
    }

    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    public function transactions()
    {
        $transactions = Transaction::with('user')->latest()->paginate(15);
        return view('admin.transactions', compact('transactions'));
    }
}