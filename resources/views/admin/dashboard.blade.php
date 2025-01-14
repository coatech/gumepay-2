<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Overview</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p>Total Users: {{ $totalUsers }}</p>
                            <p>Total Transactions: {{ $totalTransactions }}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">Recent Transactions</h4>
                            <ul>
                                @foreach($recentTransactions as $transaction)
                                    <li>{{ $transaction->user->name }} - {{ $transaction->amount }} {{ $transaction->currency }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>