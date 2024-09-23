<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Deposit Money') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="container">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Deposit Money</h2>

                    <!-- Display Errors -->
                    @if ($errors->any())
                        <div id="alert-error"
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div id="alert-success"
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Deposit Form -->
                    <form action="{{ route('deposit.money') }}" method="POST" class="mt-6">
                        @csrf
                        <div class="mb-4">
                            <label for="amount" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Enter Amount to Deposit:</label>
                            <input type="number" name="amount" id="amount" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                min="1" required>
                        </div>

                        <div>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Deposit</button>
                        </div>
                    </form>

                    <p class="mt-4 text-gray-700 dark:text-gray-300">Your current balance: {{ $balance }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Automatically hide the alert messages after 5 seconds
        setTimeout(function() {
            const alertError = document.getElementById('alert-error');
            const alertSuccess = document.getElementById('alert-success');

            if (alertError) {
                alertError.style.transition = "opacity 0.5s ease-out";
                alertError.style.opacity = 0;
                setTimeout(() => alertError.remove(), 500);
            }

            if (alertSuccess) {
                alertSuccess.style.transition = "opacity 0.5s ease-out";
                alertSuccess.style.opacity = 0;
                setTimeout(() => alertSuccess.remove(), 500);
            }
        }, 5000); // 5000ms = 5 seconds
    </script>
</x-app-layout>
