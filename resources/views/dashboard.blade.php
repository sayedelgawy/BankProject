<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Account Balance & Info') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="container">

                    <h1 class="text-2xl font-bold mb-4">Welcome to Your Bank Account</h1>
                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div id="alert-success"
                            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="bg-white shadow-md rounded p-6">
                        <h2 class="text-xl font-semibold mb-2">Account Information</h2>
                        <p class=" mb-2"><strong>Account Number:</strong> {{ $accountNumber }}</p>
                        <p class=" mb-2"><strong>Account Iban Number Used In Transactions:</strong> {{ $iban }}</p>
                        <p><strong>Balance:</strong> ${{ number_format($balance, 2) }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        // Automatically hide the alert messages after 5 seconds
        setTimeout(function() {
          
            const alertSuccess = document.getElementById('alert-success');
    
            if (alertSuccess) {
                alertSuccess.style.transition = "opacity 0.5s ease-out";
                alertSuccess.style.opacity = 0;
                setTimeout(() => alertSuccess.remove(), 500);
            }
        }, 5000); // 5000ms = 5 seconds
    </script>
    
</x-app-layout>

