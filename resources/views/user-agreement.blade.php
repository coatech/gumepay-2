<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Agreement') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Gumepay User Agreement</h3>
                    <div class="prose">
                        <!-- Add your user agreement content here -->
                        <p>By using Gumepay, you agree to the following terms and conditions...</p>
                    </div>
                    <form method="POST" action="{{ route('user-agreement.accept') }}" class="mt-6">
                        @csrf
                        <div class="flex items-center">
                            <input type="checkbox" name="agree" id="agree" class="mr-2" required>
                            <label for="agree">I have read and agree to the User Agreement</label>
                        </div>
                        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Accept and Continue
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>