<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Welcome to Gumepay</h3>
                    <p class="mb-4">Your cryptocurrency conversion platform</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold mb-2">Quick Actions</h4>
                            <ul class="list-disc list-inside">
                                <li><a href="{{ route('wallet') }}" class="text-blue-600 hover:underline">Connect Wallet</a></li>
                                <li><a href="{{ route('transactions') }}" class="text-blue-600 hover:underline">View Transactions</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">Account Overview</h4>
                            <p>Total Transactions: {{ auth()->user()->transactions()->count() }}</p>
                            <p>Last Transaction: {{ auth()->user()->transactions()->latest()->first()->created_at ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>