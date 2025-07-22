@extends('layout.user')

@section('content')
@php
$profile = auth()->user()->profile;
$bitcoin = $profile->bitcoin_address ?? null;
$etherium = $profile->etherium_address ?? null;
$usdt = $profile->usdt_address ?? null;
@endphp
@if(!$bitcoin && !$etherium && !$usdt)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert('You must add a wallet address before withdrawing.');
        const walletInfo = document.getElementById('wallet-info');
        if (walletInfo) {
            walletInfo.classList.add('hidden');
        }
    });
</script>
@endif

{{-- Flash messages --}}
@if(session('success'))
<div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 border border-green-200 flex justify-between items-center">
    <span>{{ session('success') }}</span>

    @if(session('success') === 'Withdrawal card generated!')
    <a href="{{ route('user.viewCard') }}"
        class="ml-4 px-3 py-1 text-sm rounded-full bg-[#8AC304] text-[#0C3A30] hover:bg-[#7bb502] transition">
        View Card
    </a>
    @endif
</div>
@endif

@if($errors->any())
<div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 border border-red-200 flex justify-between items-center">
    <span>{{ $errors->first() }}</span>

    @if($errors->first() === 'Please generate your withdrawal card before proceeding.')
    <form method="POST" action="{{ route('withdrawals.generateCard') }}">
        @csrf
        <button type="submit"
            class="ml-4 px-3 py-1 text-sm rounded-full bg-[#8AC304] text-[#0C3A30] hover:bg-[#7bb502] transition">
            Generate Card
        </button>
    </form>
    @endif
</div>
@endif


<div class="max-w-xl mx-auto mt-10 p-6 rounded-2xl shadow-xl border" >


    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-lg font-semibold text-[#0C3A30]">Withdraw Funds</h1>
        <a href="{{ route('user_dashboard') }}" class="text-sm text-gray-600 hover:text-lime-500">← Back to Dashboard</a>
    </div>

    <form action="{{ route('user.balance.withdraw') }}" method="POST" class="space-y-6" id="withdraw-form">
        @csrf

        {{-- Amount --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Withdrawal Amount</label>
            <div class="relative">
                <span class="absolute left-3 top-3 text-gray-500">$</span>
                <input type="number" name="amount" min="1" max="{{ auth()->user()->available_balance }}" value="{{ old('amount') }}"
                    class="w-full pl-8 pr-4 py-3 rounded-lg border focus:outline-none" style="border-color: #8AC304;" required>
           
               

            </div>
            <p class="mt-1 text-xs text-gray-500">Available: <strong>${{ number_format(auth()->user()->total_income, 2) }}</strong></p>
        </div>

        {{-- Transfer Method --}}
        <div class="relative">
            <label class="block mb-1 text-sm font-medium text-gray-700">Transfer Method</label>
            <div id="custom-dropdown" tabindex="0" class="w-full px-4 py-3 rounded-lg border cursor-pointer flex justify-between items-center hover:border-[#0C3A30]" style="border-color: #8AC304;">
                <span id="selected-option-text">Select transfer method</span>
                <svg class="w-5 h-5 text-gray-400" id="dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <select id="payment_method" name="payment_method" class="hidden" required>
                <option value="">Select</option>
                <option value="cryptocurrency">Cryptocurrency Wallet</option>
                <option value="digital_wallet">Digital Payment System</option>
            </select>
            <div id="dropdown-options" class="absolute z-10 mt-1 w-full border rounded-lg shadow-lg hidden" style="border-color: #8AC304;">
                <div class="option-item px-4 py-3 cursor-pointer" data-value="cryptocurrency">Cryptocurrency Wallet</div>
                <div class="option-item px-4 py-3 cursor-pointer" data-value="digital_wallet">Digital Payment System</div>
            </div>
        </div>

        {{-- Wallet Info --}}
        <div id="wallet-info" class="hidden mt-4 relative"></div>

        {{-- PIN --}}
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Security PIN</label>
            <div class="grid grid-cols-4 gap-2">
                @for ($i = 1; $i <= 4; $i++)
                    <input type="password" name="digit{{ $i }}" maxlength="1" required inputmode="numeric"
                    class="pin-input h-12 text-center text-xl rounded-lg border" style="border-color: #8AC304;">
                    @endfor
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" id="submitBtn" class="w-full flex items-center justify-center py-3 px-4 rounded-lg font-medium shadow hover:shadow-md transition" style="background-color: #8AC304; color:#0C3A30; margin-top:2rem;">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
            </svg>
            Initiate Withdrawal
        </button>

    </form>
</div>

{{-- SCRIPT --}}
<script>
    // prevent multiple clicking 
    document.getElementById('withdraw-form').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Processing...';
        submitBtn.style.backgroundColor = '#B2B2B2';
        submitBtn.style.color = '#333';
    });

    document.addEventListener('DOMContentLoaded', () => {
        const dropdown = document.getElementById('custom-dropdown');
        const options = document.getElementById('dropdown-options');
        const selectedText = document.getElementById('selected-option-text');
        const select = document.getElementById('payment_method');
        const walletInfo = document.getElementById('wallet-info');

        dropdown.addEventListener('click', () => {
            options.classList.toggle('hidden');
        });

        // Handle option selection
        document.querySelectorAll('.option-item').forEach(option => {
            option.addEventListener('click', function() {
                const value = this.dataset.value;
                selectedText.textContent = this.textContent;
                select.value = value;
                options.classList.add('hidden');

                if (value === 'cryptocurrency') {
                    walletInfo.classList.remove('hidden');
                    walletInfo.innerHTML = `
                        <label class="block mb-1 text-sm font-medium text-gray-700">Select Wallet</label>
                        <div id="wallet-dropdown" tabindex="0" class="w-full px-4 py-3 rounded-lg border cursor-pointer flex justify-between items-center" style="border-color: #8AC304;">
                            <span id="wallet-text">Choose wallet address</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <input type="hidden" name="wallet_choice" id="wallet_choice">
                        <div id="wallet-options" class="absolute z-20 mt-1 w-full  border rounded-lg shadow-lg hidden" style="border-color: #8AC304;">
                            @if($bitcoin)
                                <div class="wallet-item px-4 py-3 cursor-pointer" data-wallet="bitcoin">🟢 BTC - {{ $bitcoin }}</div>
                            @endif
                            @if($etherium)
                                <div class="wallet-item px-4 py-3 cursor-pointer" data-wallet="etherium">🟢 ETH - {{ $etherium }}</div>
                            @endif
                            @if($usdt)
                                <div class="wallet-item px-4 py-3 cursor-pointer" data-wallet="usdt">🟢 USDT - {{ $usdt }}</div>
                            @endif
                            @if(!$bitcoin && !$etherium && !$usdt)
                                <div class="text-red-600 px-4 py-3">
                                    No wallets found. <a href="{{ route('profile.show') }}" class="underline text-blue-600">Update Profile</a>
                                </div>
                            @endif
                        </div>
                    `;
                } else if (value === 'digital_wallet') {
                    walletInfo.classList.remove('hidden');
                    walletInfo.innerHTML = `
    <div class="text-sm text-gray-800 bg-[#f9f9f9] border border-[#8AC304] p-4 rounded-lg shadow-sm">
    For digital wallet withdrawals, please 
    <a href="#" onclick="smartsupp('chat:open'); return false;" 
      class="underline text-blue-600">
        contact support
    </a>.
</div>



                    `;
                } else {
                    walletInfo.classList.add('hidden');
                    walletInfo.innerHTML = '';
                }
            });
        });

        // Wallet dropdown toggle & selection
        document.addEventListener('click', function(e) {
            const walletDropdown = document.getElementById('wallet-dropdown');
            const walletOptions = document.getElementById('wallet-options');
            if (walletDropdown && walletDropdown.contains(e.target)) {
                walletOptions.classList.toggle('hidden');
            } else if (walletOptions && !walletOptions.contains(e.target)) {
                walletOptions.classList.add('hidden');
            }

            const walletItems = document.querySelectorAll('.wallet-item');
            walletItems.forEach(item => {
                item.addEventListener('click', function() {
                    const text = this.textContent;
                    const val = this.dataset.wallet;
                    document.getElementById('wallet-text').textContent = text;
                    document.getElementById('wallet_choice').value = val;
                    walletOptions.classList.add('hidden');
                });
            });
        });

        // PIN auto-focus jump
        const pinInputs = document.querySelectorAll('.pin-input');
        pinInputs.forEach((input, idx) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && idx < pinInputs.length - 1) {
                    pinInputs[idx + 1].focus();
                }
            });
            input.addEventListener('keydown', e => {
                if (e.key === 'Backspace' && input.value === '' && idx > 0) {
                    pinInputs[idx - 1].focus();
                }
            });
        });

        // Prevent submission if digital wallet selected
        document.getElementById('withdraw-form').addEventListener('submit', function(e) {
            const method = document.getElementById('payment_method').value;
            if (method === 'digital_wallet') {
                e.preventDefault();
                alert(" Please select Cryptocurrency Wallet or contact support.");
            }
        });
    });
</script>

<style>
    .option-item:hover,
    .wallet-item:hover {
        background-color: #8AC304 !important;
        color: #0C3A30 !important;
    }

    select:focus,
    input:focus,
    #custom-dropdown:focus,
    #wallet-dropdown:focus {
        outline: none !important;
        box-shadow: 0 0 0 2px rgba(138, 195, 4, 0.3) !important;
        border-color: #8AC304 !important;
    }
</style>
@endsection