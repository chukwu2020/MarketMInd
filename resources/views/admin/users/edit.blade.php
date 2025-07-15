@extends('layout.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5">
            <div class="flex flex-col sm:flex-row justify-between items-center" >
                <h2 class="text-2xl font-bold text-white" style="color: black;">
                    Edit User Balance
                </h2>
                <div style="color: black;" class="mt-2 sm:mt-0 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                    User No: {{ $user->id }} <br>
                        User name: {{ $user->name }}
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mx-6 mt-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium text-green-800">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Form Section -->
        <div class="px-6 py-8">
            <form action="{{ route('admin.users.updateBalance', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Available Balance -->
                    <div class="space-y-2">
                        <label for="available_balance" class="block text-sm font-medium text-gray-700">
                           User Available Balance
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input
                                type="number"
                                name="available_balance"
                                id="available_balance"
                                step="0.01"
                                min="0"
                                value="{{ old('available_balance', $user->available_balance) }}"
                                required
                                class="block w-full pl-8 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="0.00"
                            >
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">USD</span>
                            </div>
                        </div>
                        @error('available_balance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                   
                </div>

                <!-- Form Footer -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="font-medium">Back to users</span>
                    </a>
                    <button style="border: 2px solid blue; color:black;"
                        type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200"
                    >
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Update Balance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection