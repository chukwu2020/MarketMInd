@extends('layout.user')

@section('content')
<style>
    .crypto-icon {
        width: 24px;
        height: 24px;
        margin-right: 8px;
    }

    .profit-badge {
        background-color: #e6f7e6;
        color: #0C3A30;
        padding: 4px 8px;
        border-radius: 12px;
        font-weight: 600;
    }

    .wallet-card {
        border-left: 4px solid #9EDD05;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .conversion-card {
        background: linear-gradient(135deg, #f8faf7 0%, #eef7ea 100%);
        border-radius: 12px;
        padding: 16px;
    }

    .time-badge {
        background-color: #f0f7ed;
        color: #0C3A30;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 12px;
    }

    .partner-logo {
        width: 40px;
        height: 40px;
        object-fit: contain;
        margin-right: 12px;
    }

    .wallet-address-container {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        position: relative;
    }

    .crypto-logo {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .crypto-logo img {
        width: 32px;
        height: 32px;
        object-fit: contain;
    }

    .amount-display {
        font-size: 24px;
        font-weight: 700;
        color: #0C3A30;
    }

    .crypto-amount {
        font-size: 20px;
        font-weight: 600;
    }

    .conversion-rate {
        font-size: 13px;
        color: #6c757d;
    }

    .rate-source {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        color: #6c757d;
    }

    .rate-source img {
        width: 16px;
        height: 16px;
        border-radius: 2px;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .upload-area:hover {
        border-color: #9EDD05;
        background: #f8faf7;
    }

    .upload-area.dragover {
        border-color: #9EDD05;
        background: #f8faf7;
        transform: scale(1.02);
    }

    .partner-card {
        transition: all 0.3s;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
    }

    .partner-card:hover {
        border-color: #9EDD05;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .loading-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #9EDD05;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffecb5;
        color: #856404;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    .timer-display {
        font-family: 'Courier New', monospace;
        font-weight: bold;
        color: #dc3545;
    }

    .nft-promo-card {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .nft-promo-card__inner {
        position: relative;
        z-index: 2;
        background: white;
        border-radius: 12px;
        padding: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .rate-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-top: 10px;
        border-left: 4px solid #28a745;
    }

    .rate-info.loading {
        border-left-color: #9EDD05;
    }

    .rate-info.error {
        border-left-color: #dc3545;
        background: #f8d7da;
    }

    .rate-info.warning {
        border-left-color: #ffc107;
        background: #fff3cd;
    }

    /* Submit button states */
    #submitBtn {
        transition: all 0.3s ease;
    }

    #submitBtn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    #submitBtn.submitting {
        background-color: #ffcc00 !important;
        border-color: #ffcc00 !important;
        color: #000 !important;
    }

    /* Logo loading state */
    .crypto-logo.loading {
        background: #f8f9fa;
    }

    .crypto-logo.loading::after {
        content: '';
        width: 20px;
        height: 20px;
        border: 2px solid #dee2e6;
        border-top: 2px solid #9EDD05;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    .success-message {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    .error-message {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 16px;
    }
</style>

<div class="dashboard-main-body">
    <!-- Breadcrumb -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h5 class="font-semibold mb-0" style="color: #0C3A30;">Deposit </h5>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{ route('user_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600"
                    onmouseover="this.style.backgroundColor='transparent'; this.style.color='#9EDD05';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0C3A30';">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="font-medium">Confirm Deposit</li>
        </ul>
    </div>

    <!-- Status Messages -->
    <div id="statusMessages"></div>

    @if(!Session::has('deposit_details'))
    <div class="alert alert-danger">
        <iconify-icon icon="solar:danger-triangle-outline" class="mr-2"></iconify-icon>
        No deposit session found. Please start a new deposit.
    </div>
    <a href="{{ route('user.deposit') }}" class="btn btn-primary">
        <iconify-icon icon="solar:arrow-left-linear" class="mr-2"></iconify-icon>
        Start New Deposit
    </a>
    @else
    @php
    $depositDetails = Session::get('deposit_details');
    $plan = \App\Models\Plan::find($depositDetails['plan_id'] ?? null);
    $wallet = \App\Models\Wallet::find($depositDetails['wallet_id'] ?? null);

    if (!$plan || !$wallet) {
    echo '<div class="alert alert-danger"><iconify-icon icon="solar:danger-triangle-outline" class="mr-2"></iconify-icon>Invalid deposit details. Please start again.</div>';
    echo '<a href="'.route('user.deposit').'" class="btn btn-primary"><iconify-icon icon="solar:arrow-left-linear" class="mr-2"></iconify-icon>Start New Deposit</a>';
    return;
    }

    $amount = $depositDetails['amount_deposited'] ?? 0;
    $profit = ($amount * $plan->interest_rate) / 100;
    @endphp

    <!-- Session Expiry Warning -->
    <div class="alert-warning mb-1">
        <div class="flex items-center">
            <iconify-icon icon="solar:clock-circle-outline" class="mr-2"></iconify-icon>
            <span>Session expires in <span id="sessionTimer" class="timer-display">30:00</span></span>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="nft-promo-card">
        <div class="nft-promo-card__inner p-2">
            <!-- Plan Summary Card -->
            <div class="card rounded-xl p-2 shadow-sm wallet-card" style="background-image: url(assets/images/hero/hero-image-1.svg); background-repeat: no-repeat; background-size: cover; background-position:center;">
                <h6 class="text-lg font-bold text-primary-dark mb-2">
                    <iconify-icon icon="solar:chart-square-outline" class="mr-2"></iconify-icon>
                    Investment Summary
                </h6>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Plan Name</p>
                        <p class="font-semibold">{{ $plan->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Amount To Send</p>
                        <p class="font-semibold">
                            ${{ number_format($amount, 2) }} ≈
                            <span id="cryptoAmountDisplay" class="text-blue-600 font-bold">
                                <span class="loading-spinner mr-1"></span>Loading...
                            </span>
                            <span id="cryptoName">{{ $wallet->crypto_name }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Duration</p>
                        <p class="font-semibold">{{ $plan->duration }} Days</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Profit</p>
                        <p class="font-semibold profit-badge">+${{ number_format($profit, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Earnings Frequency</p>
                        <p class="font-semibold">
                            @if($plan->duration <= 28)
                                Daily Profit
                                @else
                                Weekly Profit
                                @endif
                                </p>
                    </div>
                    <div class="md:col-span-2">
                        <div id="rateInfo" class="rate-info loading">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="loading-spinner mr-2"></span>
                                    <span id="rateText">Fetching live {{ $wallet->crypto_name }} rates...</span>
                                </div>
                                <small id="lastUpdated" class="text-gray-500"></small>
                            </div>
                            <div class="mt-2 text-xs">
                                <span>Network fee: <span id="networkFee">Calculating...</span></span>
                            </div>
                            <div class="mt-1 text-xs">
                                <span id="rateSource" class="text-gray-500"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wallet Details Card -->
            <div class="lg:col-span-2 space-y-6 mt-6">
                <div class="card rounded-xl p-6 shadow-sm wallet-card" style="background-image: url(assets/images/hero/hero-image-1.svg); background-repeat: no-repeat; background-size: cover; background-position:center;">
                    <div class="flex justify-between items-center mb-4">
                        <h6 class="text-lg font-bold text-primary-dark">
                            <iconify-icon icon="solar:wallet-outline" class="mr-2"></iconify-icon>
                            Payment Information
                        </h6>
                        <span class="time-badge flex items-center gap-1">
                            <iconify-icon icon="solar:clock-circle-outline"></iconify-icon>
                            <span id="paymentTimer" class="timer-display">30:00</span>
                        </span>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="crypto-logo" id="cryptoLogoContainer">
                                    <span style="font-size: 32px;">🔗</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg">{{ $wallet->crypto_name }} Wallet</h4>
                                    <p class="text-sm text-gray-500">Send only {{ $wallet->crypto_name }} to this address</p>
                                </div>
                            </div>

                            <div class="wallet-address-container mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Wallet Address</label>
                                <div class="flex flex-wrap items-center gap-2 bg-gray-50 p-3 rounded-md border border-gray-200">
                                    <span class="font-mono text-sm text-gray-800 break-all flex-1">
                                        {{ $wallet->wallet_address }}
                                    </span>
                                    <button
                                        class="copy-btn flex items-center gap-1 text-sm text-gray-700 bg-white border border-gray-300 px-3 py-1.5 rounded-md hover:bg-gray-100 active:scale-95 transition"
                                        onclick="copyToClipboard('{{ $wallet->wallet_address }}', this)"
                                        type="button">
                                        <iconify-icon icon="solar:copy-linear" class="text-base"></iconify-icon>
                                        <span class="copy-text">Copy</span>
                                    </button>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 mb-4">You can deposit crypto from our trusted partners:</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <a href="https://www.coinbase.com/" target="_blank" rel="noopener noreferrer" class="partner-card p-3">
                                    <div class="flex items-center">
                                        <img id="coinbaseLogo" src="" alt="Coinbase" class="partner-logo">
                                        <div>
                                            <span class="font-medium text-gray-800">Coinbase</span>
                                            <p class="text-xs text-gray-500">Send Your Crypto</p>
                                        </div>
                                        <iconify-icon icon="solar:arrow-right-linear" class="text-gray-400 ml-auto"></iconify-icon>
                                    </div>
                                </a>

                                <a href="https://www.kraken.com/" target="_blank" rel="noopener noreferrer" class="partner-card p-3">
                                    <div class="flex items-center">
                                        <img id="krakenLogo" src="" alt="Kraken" class="partner-logo">
                                        <div>
                                            <span class="font-medium text-gray-800">Kraken</span>
                                            <p class="text-xs text-gray-500">Professional Trading</p>
                                        </div>
                                        <iconify-icon icon="solar:arrow-right-linear" class="text-gray-400 ml-auto"></iconify-icon>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Confirmation -->
    <div class="flex gap-6">
        <div class="space-y-4 w-full">
            <div class="card rounded-xl p-2 shadow-sm wallet-card" style="background-image: url(assets/images/hero/hero-image-1.svg); background-repeat: no-repeat; background-size: cover; background-position:center; justify-content:center; align-items:center;">
                <h6 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                    <iconify-icon icon="solar:upload-outline" class="mr-2 text-green-500"></iconify-icon>
                    Payment Confirmation
                </h6>

                <form
                    id="depositForm"
                    action="{{ route('deposit.submit') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-5">
                        <label
                            for="proof"
                            class="inline-block font-semibold text-neutral-600 text-sm mb-2">
                            Screenshot
                            <span class="text-danger-600">*</span>
                        </label>
                        <input
                            type="file"
                            name="proof"
                            class="form-control rounded-lg"
                            id="proof"
                            placeholder="Proof" />
                        <span class="text-danger">@error('proof'){{
                                            $message
                                        }}@enderror</span>
                    </div>

                    <div
                        style="
                                        display: flex;
                                        flex-wrap: wrap;
                                        gap: 1rem;
                                        justify-content: center;
                                        max-width: 100%;
                                    ">

                        <button
                            id="submitBtn"
                            type="submit"
                            style="
                                            border: 2px solid #9edd05;
                                            background-color: #9edd05;
                                            color: #0c3a30;
                                            padding: 0.75rem 2rem;
                                            font-size: 1rem;
                                            border-radius: 0.5rem;
                                            width: 100%;
                                            max-width: 220px;
                                        ">
                            Submit Deposit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endif
</div>

<script>
    // Configuration
    const CONFIG = {
        cryptoName: '{{ $wallet->crypto_name ?? "BTC" }}',
        amountUSD: {{ $amount ?? 0 }},
        sessionDuration: 30 * 60,
        updateInterval: 45000, // Update every 45 seconds
        retryDelay: 10000, // Retry failed requests after 10 seconds
        maxRetries: 5
    };

    // Global state
    let retryCount = 0;
    let currentRate = null;
    let lastUpdateTime = null;

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing deposit confirmation page...');
        
        initializeTimers();
        loadCryptoLogos();
        loadPartnerLogos();
        
        // Initial rate fetch with delay to ensure page is ready
        setTimeout(() => {
            updateConversionRates();
        }, 1000);
        
        // Set up periodic updates
        setInterval(updateConversionRates, CONFIG.updateInterval);
        
        // Update when page becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                console.log('Page became visible, updating rates...');
                updateConversionRates();
            }
        });
    });

    // Utility Functions
    function showMessage(message, type = 'info') {
        const statusDiv = document.getElementById('statusMessages');
        if (!statusDiv) return;

        const messageClass = type === 'success' ? 'success-message' : 
                           type === 'error' ? 'error-message' : 
                           'alert-warning';

        const messageHtml = `
            <div class="${messageClass}" style="display: flex; align-items: center; margin-bottom: 16px;">
                <iconify-icon icon="solar:${type === 'success' ? 'check-circle' : type === 'error' ? 'danger-triangle' : 'info-circle'}-outline" class="mr-2"></iconify-icon>
                ${message}
            </div>
        `;

        statusDiv.innerHTML = messageHtml;
        setTimeout(() => {
            if (statusDiv.innerHTML === messageHtml) {
                statusDiv.innerHTML = '';
            }
        }, 5000);
    }

    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const original = btn.querySelector('.copy-text').textContent;
            btn.querySelector('.copy-text').textContent = 'Copied!';
            btn.style.backgroundColor = '#28a745';
            btn.style.color = 'white';
            setTimeout(() => {
                btn.querySelector('.copy-text').textContent = original;
                btn.style.backgroundColor = '';
                btn.style.color = '';
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy!', err);
            showMessage('Failed to copy address', 'error');
        });
    }

    // Timer Functions
    function initializeTimers() {
        let timeLeft = CONFIG.sessionDuration;

        function updateTimers() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            const sessionTimer = document.getElementById('sessionTimer');
            const paymentTimer = document.getElementById('paymentTimer');
            
            if (sessionTimer) sessionTimer.textContent = timeString;
            if (paymentTimer) paymentTimer.textContent = timeString;

            // Change color when time is running low
            if (timeLeft <= 300) { // 5 minutes
                document.querySelectorAll('.timer-display').forEach(el => {
                    el.style.color = '#dc3545';
                });
            }

            // Disable submit when time expires
            if (timeLeft <= 0) {
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Session Expired';
                }
                showMessage('Session has expired. Please start a new deposit.', 'error');
                return;
            }

            timeLeft--;
        }

        updateTimers();
        setInterval(updateTimers, 1000);
    }

    // Logo Functions
    function loadCryptoLogos() {
        const cryptoLogoContainer = document.getElementById('cryptoLogoContainer');
        if (!cryptoLogoContainer) return;

        // Enhanced crypto emoji mapping
        const cryptoEmojis = {
            'BTC': '₿',
            'ETH': '♦️',
            'LTC': 'Ł',
            'USDT': '💲',
            'BNB': '🔸',
            'ADA': '🎯',
            'DOT': '⚫',
            'XRP': '💧'
        };

        const emoji = cryptoEmojis[CONFIG.cryptoName.toUpperCase()] || '🔗';
        cryptoLogoContainer.innerHTML = `<span style="font-size: 32px;">${emoji}</span>`;
    }

    function loadPartnerLogos() {
        // Use reliable base64 encoded logos for production
        const coinbaseLogoBase64 = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iMjAiIGZpbGw9IiMwMDUyRkYiLz4KPHR5cGUgdGV4dD0iQ0IiIHg9IjIwIiB5PSIyNiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZmlsbD0id2hpdGUiIGZvbnQtc2l6ZT0iMTIiIGZvbnQtd2VpZ2h0PSJib2xkIi8+Cjwvc3ZnPgo=";
        
        const krakenLogoBase64 = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iOCIgZmlsbD0iIzU3NDFEOCIvPgo8dGV4dCB4PSIyMCIgeT0iMjYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IndoaXRlIiBmb250LXNpemU9IjEwIiBmb250LXdlaWdodD0iYm9sZCI+S1JLPC90ZXh0Pgo8L3N2Zz4K";

        const coinbaseLogo = document.getElementById('coinbaseLogo');
        const krakenLogo = document.getElementById('krakenLogo');

        if (coinbaseLogo) coinbaseLogo.src = coinbaseLogoBase64;
        if (krakenLogo) krakenLogo.src = krakenLogoBase64;
    }

    // Enhanced Rate Fetching with Multiple APIs and Better Error Handling
    async function updateConversionRates() {
        const rateInfo = document.getElementById('rateInfo');
        const rateText = document.getElementById('rateText');
        const cryptoAmountDisplay = document.getElementById('cryptoAmountDisplay');
        const networkFee = document.getElementById('networkFee');
        const lastUpdated = document.getElementById('lastUpdated');
        const rateSource = document.getElementById('rateSource');

        if (!rateInfo || !rateText || !cryptoAmountDisplay) {
            console.error('Required elements not found');
            return;
        }

        try {
            // Show loading state
            rateInfo.className = 'rate-info loading';
            rateText.innerHTML = `<span class="loading-spinner mr-2"></span>Fetching live ${CONFIG.cryptoName} rates...`;

            const rateData = await fetchCryptoRates();
            
            if (rateData && rateData.price > 0) {
                // Calculate crypto amount with proper precision
                const cryptoAmount = (CONFIG.amountUSD / rateData.price);
                const formattedAmount = formatCryptoAmount(cryptoAmount, CONFIG.cryptoName);
                
                // Update display
                cryptoAmountDisplay.innerHTML = `<span class="text-green-600 font-bold">${formattedAmount}</span>`;
                
                // Update rate info
                rateInfo.className = 'rate-info';
                rateText.innerHTML = `
                    <strong>1 ${CONFIG.cryptoName} = $${rateData.price.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: CONFIG.cryptoName === 'BTC' ? 2 : 4
                    })}</strong>
                    ${rateData.change24h ? `<span class="ml-2 text-sm ${rateData.change24h >= 0 ? 'text-green-600' : 'text-red-600'}">(${rateData.change24h >= 0 ? '+' : ''}${rateData.change24h.toFixed(2)}%)</span>` : ''}
                `;
                
                // Update network fee
                if (networkFee) {
                    const fees = getNetworkFees(CONFIG.cryptoName);
                    networkFee.textContent = `${fees.min} - ${fees.max}`;
                }
                
                // Update timestamps and source
                if (lastUpdated) {
                    lastUpdated.textContent = `Updated: ${new Date().toLocaleTimeString()}`;
                }
                if (rateSource) {
                    rateSource.textContent = `Source: ${rateData.source} • Refreshes every 45s`;
                }
                
                // Store current rate and reset retry count
                currentRate = rateData;
                retryCount = 0;
                lastUpdateTime = Date.now();
                
                console.log(`Rate updated: 1 ${CONFIG.cryptoName} = ${rateData.price}`);
                
            } else {
                throw new Error('Invalid rate data received');
            }

        } catch (error) {
            console.error('Rate fetch error:', error);
            handleRateError(error);
        }
    }

    async function fetchCryptoRates() {
        const cryptoMappings = {
            'BTC': { coingecko: 'bitcoin', coinpaprika: 'btc-bitcoin' },
            'ETH': { coingecko: 'ethereum', coinpaprika: 'eth-ethereum' },
            'LTC': { coingecko: 'litecoin', coinpaprika: 'ltc-litecoin' },
            'USDT': { coingecko: 'tether', coinpaprika: 'usdt-tether' },
            'BNB': { coingecko: 'binancecoin', coinpaprika: 'bnb-binance-coin' },
            'ADA': { coingecko: 'cardano', coinpaprika: 'ada-cardano' },
            'DOT': { coingecko: 'polkadot', coinpaprika: 'dot-polkadot' },
            'XRP': { coingecko: 'ripple', coinpaprika: 'xrp-xrp' }
        };

        const mapping = cryptoMappings[CONFIG.cryptoName.toUpperCase()];
        if (!mapping) {
            throw new Error(`Unsupported cryptocurrency: ${CONFIG.cryptoName}`);
        }

        // Multiple API endpoints for redundancy
        const apiEndpoints = [
            {
                name: 'CoinGecko',
                url: `https://api.coingecko.com/api/v3/simple/price?ids=${mapping.coingecko}&vs_currencies=usd&include_24hr_change=true&include_last_updated_at=true`,
                parser: (data) => {
                    const coinData = data[mapping.coingecko];
                    if (!coinData) return null;
                    return {
                        price: coinData.usd,
                        change24h: coinData.usd_24h_change,
                        lastUpdated: coinData.last_updated_at
                    };
                }
            },
            {
                name: 'CoinPaprika',
                url: `https://api.coinpaprika.com/v1/tickers/${mapping.coinpaprika}`,
                parser: (data) => {
                    if (!data.quotes?.USD) return null;
                    return {
                        price: data.quotes.USD.price,
                        change24h: data.quotes.USD.percent_change_24h,
                        lastUpdated: data.last_updated
                    };
                }
            },
            {
                name: 'CryptoCompare',
                url: `https://min-api.cryptocompare.com/data/price?fsym=${CONFIG.cryptoName.toUpperCase()}&tsyms=USD`,
                parser: (data) => {
                    if (!data.USD) return null;
                    return {
                        price: data.USD,
                        change24h: null,
                        lastUpdated: Date.now() / 1000
                    };
                }
            }
        ];

        // Try each API with timeout and proper error handling
        for (const endpoint of apiEndpoints) {
            try {
                console.log(`Trying ${endpoint.name} API...`);
                
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

                const response = await fetch(endpoint.url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Cache-Control': 'no-cache'
                    },
                    signal: controller.signal
                });
                
                clearTimeout(timeoutId);
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const data = await response.json();
                const parsedData = endpoint.parser(data);

                if (parsedData && parsedData.price > 0) {
                    console.log(`✓ ${endpoint.name} API successful: ${parsedData.price}`);
                    return {
                        ...parsedData,
                        source: endpoint.name
                    };
                } else {
                    throw new Error('Invalid price data');
                }
                
            } catch (error) {
                console.warn(`✗ ${endpoint.name} API failed:`, error.message);
                continue;
            }
        }

        // If all APIs fail, throw error
        throw new Error('All rate APIs failed');
    }

    function handleRateError(error) {
        const rateInfo = document.getElementById('rateInfo');
        const rateText = document.getElementById('rateText');
        const cryptoAmountDisplay = document.getElementById('cryptoAmountDisplay');
        const networkFee = document.getElementById('networkFee');
        const rateSource = document.getElementById('rateSource');

        retryCount++;

        if (currentRate && lastUpdateTime && (Date.now() - lastUpdateTime < 300000)) {
            // Use cached rate if less than 5 minutes old
            rateInfo.className = 'rate-info warning';
            rateText.innerHTML = `
                <iconify-icon icon="solar:wifi-router-minimalistic-outline" class="mr-1"></iconify-icon>
                Using cached rate: <strong>1 ${CONFIG.cryptoName} = ${currentRate.price.toLocaleString()}</strong>
            `;
            
            if (rateSource) {
                rateSource.textContent = `Connection issue • Retrying... (${retryCount}/${CONFIG.maxRetries})`;
            }
            
            // Calculate with cached rate
            const cryptoAmount = (CONFIG.amountUSD / currentRate.price);
            const formattedAmount = formatCryptoAmount(cryptoAmount, CONFIG.cryptoName);
            cryptoAmountDisplay.innerHTML = `<span class="text-orange-600 font-bold">${formattedAmount}</span>`;
            
        } else {
            // Use fallback rates
            const fallbackRate = getFallbackRates(CONFIG.cryptoName);
            const cryptoAmount = (CONFIG.amountUSD / fallbackRate);
            const formattedAmount = formatCryptoAmount(cryptoAmount, CONFIG.cryptoName);
            
            rateInfo.className = 'rate-info error';
            rateText.innerHTML = `
                <iconify-icon icon="solar:danger-triangle-outline" class="mr-1"></iconify-icon>
                Using offline rate: <strong>1 ${CONFIG.cryptoName} = ${fallbackRate.toLocaleString()}</strong>
            `;
            
            cryptoAmountDisplay.innerHTML = `<span class="text-red-600 font-bold">${formattedAmount}</span>`;
            
            if (rateSource) {
                rateSource.textContent = `Offline mode • Please check connection`;
            }
        }

        // Update network fee with fallback
        if (networkFee) {
            const fees = getNetworkFees(CONFIG.cryptoName);
            networkFee.textContent = `${fees.min} - ${fees.max}`;
        }

        // Schedule retry if under max retry limit
        if (retryCount < CONFIG.maxRetries) {
            const retryDelay = Math.min(CONFIG.retryDelay * retryCount, 60000); // Max 1 minute
            console.log(`Scheduling retry ${retryCount + 1} in ${retryDelay / 1000}s...`);
            setTimeout(updateConversionRates, retryDelay);
        }
    }

    function formatCryptoAmount(amount, cryptoName) {
        // Different precision for different cryptocurrencies
        const precisionMap = {
            'BTC': 8,
            'ETH': 6,
            'LTC': 6,
            'USDT': 2,
            'BNB': 4,
            'ADA': 2,
            'DOT': 4,
            'XRP': 2
        };

        const precision = precisionMap[cryptoName.toUpperCase()] || 6;
        return amount.toFixed(precision);
    }

    function getNetworkFees(cryptoName) {
        // Updated network fee estimates (in USD)
        const networkFees = {
            'BTC': { min: 3.00, max: 12.00 },
            'ETH': { min: 5.00, max: 25.00 },
            'LTC': { min: 0.10, max: 0.50 },
            'USDT': { min: 5.00, max: 25.00 }, // ERC-20 fees
            'BNB': { min: 0.50, max: 2.00 },
            'ADA': { min: 0.20, max: 1.00 },
            'DOT': { min: 0.30, max: 1.50 },
            'XRP': { min: 0.01, max: 0.05 }
        };
        return networkFees[cryptoName.toUpperCase()] || networkFees['BTC'];
    }

    function getFallbackRates(cryptoName) {
        // Conservative fallback rates (slightly dated but safe)
        const fallbackRates = {
            'BTC': 95000,
            'ETH': 3500,
            'LTC': 120,
            'USDT': 1.00,
            'BNB': 600,
            'ADA': 1.20,
            'DOT': 15.00,
            'XRP': 0.65
        };
        return fallbackRates[cryptoName.toUpperCase()] || 95000;
    }

    // Enhanced Form Submission
    document.addEventListener('DOMContentLoaded', function() {
        const depositForm = document.getElementById('depositForm');
        const submitBtn = document.getElementById('submitBtn');
        const fileInput = document.getElementById('proof');

        if (!depositForm || !submitBtn || !fileInput) {
            console.error('Form elements not found');
            return;
        }

        // File validation
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && !validateFile(file)) {
                fileInput.value = '';
                return;
            }
        });

        // Form submission
        depositForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate file
            if (!fileInput.files.length) {
                showMessage('Please upload payment proof screenshot', 'error');
                return;
            }

            const file = fileInput.files[0];
            if (!validateFile(file)) {
                return;
            }

            // Update button state
            submitBtn.disabled = true;
            submitBtn.className = 'submitting';
            submitBtn.style.backgroundColor = '#ffcc00';
            submitBtn.style.borderColor = '#ffcc00';
            submitBtn.style.color = '#000';
            submitBtn.innerHTML = `
                <span class="loading-spinner mr-2"></span>
                Processing...
            `;

            // Submit form
            submitFormData();
        });

        async function submitFormData() {
            try {
                const formData = new FormData(depositForm);
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                                 document.querySelector('input[name="_token"]')?.value;

                const response = await fetch(depositForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                if (response.ok) {
                    // Success
                    submitBtn.innerHTML = `
                        <iconify-icon icon="solar:check-circle-bold" class="mr-2"></iconify-icon>
                        Success!
                    `;
                    submitBtn.style.backgroundColor = '#28a745';
                    submitBtn.style.borderColor = '#28a745';
                    submitBtn.style.color = '#fff';
                    
                    showMessage('Deposit submitted successfully! Redirecting...', 'success');
                    
                    // Handle redirect
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        const result = await response.json();
                        setTimeout(() => {
                            window.location.href = result.redirect || '{{ route("user_dashboard") }}';
                        }, 2000);
                    } else {
                        setTimeout(() => {
                            window.location.href = response.url || '{{ route("user_dashboard") }}';
                        }, 2000);
                    }
                    
                } else {
                    // Handle errors
                    let errorMessage = 'Submission failed. Please try again.';
                    
                    try {
                        const errorData = await response.json();
                        errorMessage = errorData.message || errorMessage;
                    } catch (e) {
                        errorMessage = `Server error: ${response.status}`;
                    }
                    
                    throw new Error(errorMessage);
                }

            } catch (error) {
                console.error('Submission error:', error);
                
                // Reset button
                resetSubmitButton();
                showMessage(error.message || 'Failed to submit deposit. Please try again.', 'error');
            }
        }

        function resetSubmitButton() {
            submitBtn.disabled = false;
            submitBtn.className = '';
            submitBtn.style.backgroundColor = '#9edd05';
            submitBtn.style.borderColor = '#9edd05';
            submitBtn.style.color = '#0c3a30';
            submitBtn.innerHTML = 'Submit Deposit';
        }

        function validateFile(file) {
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'application/pdf'];
            const maxSize = 10 * 1024 * 1024; // 10MB

            if (!allowedTypes.includes(file.type)) {
                showMessage('Invalid file type. Please upload PNG, JPG, WEBP, or PDF files only.', 'error');
                return false;
            }

            if (file.size > maxSize) {
                showMessage('File too large. Maximum size is 10MB.', 'error');
                return false;
            }

            return true;
        }

        // Prevent accidental page leave
        window.addEventListener('beforeunload', function(e) {
            const hasFile = fileInput && fileInput.files.length > 0;
            const isSubmitting = submitBtn && submitBtn.disabled;

            if (hasFile && !isSubmitting) {
                e.preventDefault();
                e.returnValue = 'You have selected a file but haven\'t submitted the deposit. Are you sure you want to leave?';
                return e.returnValue;
            }
        });
    });

    // Network status detection
    window.addEventListener('online', function() {
        console.log('Connection restored, updating rates...');
        showMessage('Connection restored', 'success');
        updateConversionRates();
    });

    window.addEventListener('offline', function() {
        console.log('Connection lost');
        showMessage('Connection lost - using cached rates', 'error');
    });

    // Global error handler
    window.addEventListener('error', function(e) {
        console.error('Global error:', e.error);
    });

    // Performance monitoring
    if (typeof performance !== 'undefined') {
        window.addEventListener('load', function() {
            setTimeout(() => {
                const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
                console.log(`Page loaded in ${loadTime}ms`);
            }, 0);
        });
    }
</script>

@endsection