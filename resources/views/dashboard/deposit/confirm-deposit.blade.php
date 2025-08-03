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

    /* HIDDEN RATE DISPLAY SECTION */
    .rate-info,
    .rate-card,
    .rate-display-section {
        display: none !important;
        visibility: hidden !important;
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

    .crypto-conversion {
        background: #f8faf7;
        border-radius: 8px;
        padding: 12px;
        margin-top: 8px;
        border: 1px solid #e5e7eb;
    }

    .price-display {
        font-size: 18px;
        font-weight: 700;
        color: #059669;
    }

    .change-indicator {
        font-size: 14px;
        font-weight: 600;
        margin-left: 8px;
    }

    .change-positive {
        color: #059669;
    }

    .change-negative {
        color: #dc2626;
    }

    /* Loading state for crypto amount */
    .crypto-amount-loading {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: 4px;
        height: 20px;
        width: 150px;
        display: inline-block;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
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
                                <span class="crypto-amount-loading"></span>
                            </span>
                            <span id="cryptoSymbol">{{ strtoupper($wallet->crypto_name) }}</span>
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
                    <div>
                        
                    </div>
                    
                    <!-- HIDDEN RATE DISPLAY SECTION -->
                    <div class="md:col-span-2 rate-display-section" style="display: none !important;">
                        <div id="rateCard" class="rate-card loading" style="display: none !important;">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <span class="loading-spinner mr-2"></span>
                                    <span id="rateText" class="font-semibold">Fetching live {{ strtoupper($wallet->crypto_name) }} rate...</span>
                                </div>
                                <small id="lastUpdated" class="text-gray-500"></small>
                            </div>
                            
                            <div id="priceDisplay" class="mb-2" style="display: none;">
                                <span class="price-display">1 {{ strtoupper($wallet->crypto_name) }} = </span>
                                <span id="currentPrice" class="price-display">$0.00</span>
                                <span id="priceChange" class="change-indicator"></span>
                            </div>
                            
                            <div id="conversionDisplay" class="crypto-conversion" style="display: none;">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">You will send:</span>
                                    <span id="exactAmount" class="font-bold text-lg"></span>
                                </div>
                            
                            </div>
                            
                            <div class="mt-2 pt-2 border-t border-gray-200">
                                <div class="flex justify-between items-center text-xs">
                                    <span id="rateSource" class="text-gray-500">📡 Fetching from multiple sources...</span>
                                    <span id="fetchTime" class="text-gray-500"></span>
                                </div>
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
                                    <h4 class="font-bold text-lg">{{ strtoupper($wallet->crypto_name) }} Wallet</h4>
                                    <p class="text-sm text-gray-500">Send only {{ strtoupper($wallet->crypto_name) }} to this address</p>
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
                                <a href="https://www.bybit.com/" target="_blank" rel="noopener noreferrer" class="partner-card p-3">
                                    <div class="flex items-center">
                                        <img id="bybitLogo" src="" alt="Bybit" class="partner-logo">
                                        <div>
                                            <span class="font-medium text-gray-800">Bybit</span>
                                            <p class="text-xs text-gray-500">Professional Trading</p>
                                        </div>
                                        <iconify-icon icon="solar:arrow-right-linear" class="text-gray-400 ml-auto"></iconify-icon>
                                    </div>
                                </a>

                                <a href="https://trustwallet.com/" target="_blank" rel="noopener noreferrer" class="partner-card p-3">
                                    <div class="flex items-center">
                                        <img id="trustWalletLogo" src="" alt="Trust Wallet" class="partner-logo">
                                        <div>
                                            <span class="font-medium text-gray-800">Trust Wallet</span>
                                            <p class="text-xs text-gray-500">Mobile Wallet</p>
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
                        <span class="text-danger">@error('proof'){{ $message }}@enderror</span>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; max-width: 100%;">
                        <button
                            id="submitBtn"
                            type="submit"
                            style="border: 2px solid #9edd05; background-color: #9edd05; color: #0c3a30; padding: 0.75rem 2rem; font-size: 1rem; border-radius: 0.5rem; width: 100%; max-width: 220px;">
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
    // ========================================
    // IMPROVED CRYPTOCURRENCY RATE SYSTEM
    // ========================================

    const CONFIG = {
        cryptoName: '{{ $wallet->crypto_name ?? "BTC" }}',
        amountUSD: {{ $amount ?? 0 }},
        sessionDuration: 30 * 60,
        updateInterval: 60000, // 1 minute for background updates
        retryDelay: 3000,
        maxRetries: 3
    };

    let globalState = {
        currentRate: null,
        lastUpdate: null,
        retryCount: 0,
        isOnline: navigator.onLine,
        fetchInProgress: false
    };

    // Initialize system when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log(`🚀 Initializing for ${CONFIG.cryptoName.toUpperCase()}`);
        
        initializeTimers();
        loadCryptoLogos();
        loadPartnerLogos();
        
        // Start immediate rate fetching (background process)
        fetchCryptoRateAndCalculate();
        
        // Set up periodic background updates
        setInterval(fetchCryptoRateAndCalculate, CONFIG.updateInterval);
    });

    // ========================================
    // ENHANCED CRYPTO SYMBOL NORMALIZATION
    // ========================================

    function normalizeCryptoSymbol(input) {
        const normalized = input.toString().trim().toUpperCase();
        
        const symbolMap = {
            'BTC': 'BTC', 'BITCOIN': 'BTC', 'BITCOINS': 'BTC',
            'ETH': 'ETH', 'ETHEREUM': 'ETH', 'ETHER': 'ETH', 'ETHERIUM': 'ETH',
            'LTC': 'LTC', 'LITECOIN': 'LTC', 'LITE COIN': 'LTC',
            'USDT': 'USDT', 'TETHER': 'USDT', 'USDT-ERC20': 'USDT', 'USDT-TRC20': 'USDT',
            'BNB': 'BNB', 'BINANCE COIN': 'BNB', 'BINANCECOIN': 'BNB',
            'ADA': 'ADA', 'CARDANO': 'ADA',
            'DOT': 'DOT', 'POLKADOT': 'DOT',
            'XRP': 'XRP', 'RIPPLE': 'XRP',
            'SOL': 'SOL', 'SOLANA': 'SOL',
            'DOGE': 'DOGE', 'DOGECOIN': 'DOGE',
            'MATIC': 'MATIC', 'POLYGON': 'MATIC',
            'AVAX': 'AVAX', 'AVALANCHE': 'AVAX',
            'LINK': 'LINK', 'CHAINLINK': 'LINK',
            'UNI': 'UNI', 'UNISWAP': 'UNI'
        };

        return symbolMap[normalized] || normalized;
    }

    function getCryptoApiMappings(symbol) {
        const normalizedSymbol = normalizeCryptoSymbol(symbol);
        
        const mappings = {
            'BTC': { coingecko: 'bitcoin', precision: 8, name: 'Bitcoin' },
            'ETH': { coingecko: 'ethereum', precision: 6, name: 'Ethereum' },
            'LTC': { coingecko: 'litecoin', precision: 6, name: 'Litecoin' },
            'USDT': { coingecko: 'tether', precision: 4, name: 'Tether' },
            'BNB': { coingecko: 'binancecoin', precision: 5, name: 'Binance Coin' },
            'ADA': { coingecko: 'cardano', precision: 4, name: 'Cardano' },
            'DOT': { coingecko: 'polkadot', precision: 4, name: 'Polkadot' },
            'XRP': { coingecko: 'ripple', precision: 4, name: 'XRP' },
            'SOL': { coingecko: 'solana', precision: 4, name: 'Solana' },
            'DOGE': { coingecko: 'dogecoin', precision: 3, name: 'Dogecoin' },
            'MATIC': { coingecko: 'matic-network', precision: 4, name: 'Polygon' },
            'AVAX': { coingecko: 'avalanche-2', precision: 4, name: 'Avalanche' },
            'LINK': { coingecko: 'chainlink', precision: 4, name: 'Chainlink' },
            'UNI': { coingecko: 'uniswap', precision: 4, name: 'Uniswap' }
        };

        return mappings[normalizedSymbol] || mappings['BTC'];
    }

    // ========================================
    // BACKGROUND RATE FETCHING & CALCULATION
    // ========================================

    async function fetchCryptoRateAndCalculate() {
        if (globalState.fetchInProgress) return;

        globalState.fetchInProgress = true;
        const cryptoSymbol = normalizeCryptoSymbol(CONFIG.cryptoName);
        
        console.log(`📊 Fetching live rate for ${cryptoSymbol}...`);

        try {
            const rateData = await fetchFromCoinGecko(cryptoSymbol);
            
            if (rateData && rateData.price > 0) {
                // Calculate accurate crypto amount
                const cryptoAmount = calculateAccurateCryptoAmount(CONFIG.amountUSD, rateData.price, cryptoSymbol);
                
                // Update global state
                globalState.currentRate = rateData;
                globalState.lastUpdate = Date.now();
                globalState.retryCount = 0;
                
                // Update only the visible crypto amount display
                updateCryptoAmountDisplay(cryptoAmount, cryptoSymbol);
                
                console.log(`✅ ${cryptoSymbol} rate: $${rateData.price} | Amount: ${cryptoAmount.formatted}`);
                
            } else {
                throw new Error('Invalid rate data');
            }

        } catch (error) {
            console.error('❌ Rate fetch failed:', error);
            handleRateError(cryptoSymbol);
        } finally {
            globalState.fetchInProgress = false;
        }
    }

    // Simplified CoinGecko API fetch
    async function fetchFromCoinGecko(cryptoSymbol) {
        const apiMappings = getCryptoApiMappings(cryptoSymbol);
        
        try {
            const response = await fetch(
                `https://api.coingecko.com/api/v3/simple/price?ids=${apiMappings.coingecko}&vs_currencies=usd&include_24hr_change=true`,
                { 
                    method: 'GET',
                    headers: { 'Accept': 'application/json' },
                    signal: AbortSignal.timeout(10000)
                }
            );
            
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            const coinData = data[apiMappings.coingecko];
            
            if (!coinData?.usd || coinData.usd <= 0) {
                throw new Error('Invalid price data');
            }
            
            return {
                price: parseFloat(coinData.usd),
                change24h: coinData.usd_24h_change ? parseFloat(coinData.usd_24h_change) : null,
                source: 'CoinGecko',
                timestamp: Date.now()
            };
            
        } catch (error) {
            console.warn('CoinGecko failed, trying Binance...');
            return await fetchFromBinance(cryptoSymbol);
        }
    }

    // Fallback to Binance API
    async function fetchFromBinance(cryptoSymbol) {
        const binanceSymbols = {
            'BTC': 'BTCUSDT', 'ETH': 'ETHUSDT', 'LTC': 'LTCUSDT',
            'USDT': 'USDTUSD', 'BNB': 'BNBUSDT', 'ADA': 'ADAUSDT',
            'DOT': 'DOTUSDT', 'XRP': 'XRPUSDT', 'SOL': 'SOLUSDT',
            'DOGE': 'DOGEUSDT', 'MATIC': 'MATICUSDT', 'AVAX': 'AVAXUSDT',
            'LINK': 'LINKUSDT', 'UNI': 'UNIUSDT'
        };

        const binanceSymbol = binanceSymbols[cryptoSymbol] || 'BTCUSDT';
        
        try {
            const response = await fetch(
                `https://api.binance.com/api/v3/ticker/24hr?symbol=${binanceSymbol}`,
                {
                    method: 'GET',
                    headers: { 'Accept': 'application/json' },
                    signal: AbortSignal.timeout(8000)
                }
            );
            
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const data = await response.json();
            
            if (!data.lastPrice || parseFloat(data.lastPrice) <= 0) {
                throw new Error('Invalid price data');
            }
            
            return {
                price: parseFloat(data.lastPrice),
                change24h: data.priceChangePercent ? parseFloat(data.priceChangePercent) : null,
                source: 'Binance',
                timestamp: Date.now()
            };
            
        } catch (error) {
            console.warn('Binance also failed, using fallback rate');
            throw error;
        }
    }

    // ========================================
    // ACCURATE CALCULATION FUNCTIONS
    // ========================================

    function calculateAccurateCryptoAmount(usdAmount, cryptoPrice, cryptoSymbol) {
        const apiMappings = getCryptoApiMappings(cryptoSymbol);
        const precision = apiMappings.precision || 6;
        
        // High-precision calculation
        const exactAmount = usdAmount / cryptoPrice;
        const preciseAmount = parseFloat(exactAmount.toFixed(precision));
        
        console.log(`🧮 Calculation: ${usdAmount} ÷ ${cryptoPrice} = ${preciseAmount} ${cryptoSymbol}`);
        
        return {
            amount: preciseAmount,
            formatted: formatCryptoAmount(preciseAmount, cryptoSymbol, precision)
        };
    }

    function formatCryptoAmount(amount, cryptoSymbol, precision = null) {
        const apiMappings = getCryptoApiMappings(cryptoSymbol);
        const displayPrecision = precision || apiMappings.precision || 6;
        
        // Format with appropriate decimal places
        let formatted = amount.toFixed(displayPrecision);
        
        // Remove trailing zeros but keep at least 2 decimal places for small amounts
        const minDecimals = amount < 1 ? Math.min(4, displayPrecision) : 2;
        formatted = parseFloat(formatted).toFixed(minDecimals);
        
        // Add thousands separators for better readability
        return parseFloat(formatted).toLocaleString('en-US', {
            minimumFractionDigits: minDecimals,
            maximumFractionDigits: displayPrecision
        });
    }

    // ========================================
    // SIMPLIFIED UI UPDATE (VISIBLE ONLY)
    // ========================================

    function updateCryptoAmountDisplay(cryptoAmount, cryptoSymbol) {
        const cryptoAmountDisplay = document.getElementById('cryptoAmountDisplay');
        
        if (cryptoAmountDisplay) {
            // Update only the visible crypto amount with success styling
            cryptoAmountDisplay.innerHTML = `<span class="text-green-600 font-bold">${cryptoAmount.formatted}</span>`;
        }
        
        // Log for debugging but don't show to user
        console.log(`💰 Updated display: ${cryptoAmount.formatted} ${cryptoSymbol}`);
    }

    function handleRateError(cryptoSymbol) {
        globalState.retryCount++;
        console.log(`🔄 Error handled (retry ${globalState.retryCount}/${CONFIG.maxRetries})`);
        
        // Use cached data if available and recent (within 10 minutes)
        if (globalState.currentRate && globalState.lastUpdate && 
            (Date.now() - globalState.lastUpdate < 600000)) {
            
            const cachedAmount = calculateAccurateCryptoAmount(CONFIG.amountUSD, globalState.currentRate.price, cryptoSymbol);
            updateCryptoAmountDisplay(cachedAmount, cryptoSymbol);
            console.log('⚠️ Using cached rate data');
            
        } else {
            // Use smart fallback rates
            const fallbackRate = getSmartFallbackRate(cryptoSymbol);
            const fallbackAmount = calculateAccurateCryptoAmount(CONFIG.amountUSD, fallbackRate, cryptoSymbol);
            
            const cryptoAmountDisplay = document.getElementById('cryptoAmountDisplay');
            if (cryptoAmountDisplay) {
                cryptoAmountDisplay.innerHTML = `<span class="text-orange-600 font-bold">${fallbackAmount.formatted}</span>`;
            }
            
            console.log('🚫 Using offline fallback rate');
        }
        
        // Schedule retry if under limit
        if (globalState.retryCount < CONFIG.maxRetries) {
            const retryDelay = CONFIG.retryDelay * globalState.retryCount;
            setTimeout(fetchCryptoRateAndCalculate, retryDelay);
        }
    }

    function getSmartFallbackRate(cryptoSymbol) {
        // Updated fallback rates (December 2024)
        const fallbackRates = {
            'BTC': 95000, 'ETH': 3600, 'LTC': 105, 'USDT': 1.00,
            'BNB': 650, 'ADA': 1.20, 'DOT': 8.50, 'XRP': 0.65,
            'SOL': 200, 'DOGE': 0.35, 'MATIC': 1.10, 'AVAX': 42,
            'LINK': 22, 'UNI': 12
        };
        return fallbackRates[cryptoSymbol] || 95000;
    }

    // ========================================
    // UTILITY FUNCTIONS
    // ========================================

    function showMessage(message, type = 'info') {
        const statusDiv = document.getElementById('statusMessages');
        if (!statusDiv) return;

        const messageClass = type === 'success' ? 'success-message' : 
                           type === 'error' ? 'error-message' : 
                           'alert-warning';

        const icons = {
            success: 'check-circle',
            error: 'danger-triangle',
            warning: 'warning-triangle',
            info: 'info-circle'
        };

        const messageHtml = `
            <div class="${messageClass}" style="display: flex; align-items: center; margin-bottom: 16px;">
                <iconify-icon icon="solar:${icons[type]}-outline" class="mr-2"></iconify-icon>
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
            console.error('Failed to copy:', err);
            showMessage('Failed to copy address', 'error');
        });
    }

    // ========================================
    // TIMER FUNCTIONS
    // ========================================

    function initializeTimers() {
        let timeLeft = CONFIG.sessionDuration;

        function updateTimers() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            const timers = ['sessionTimer', 'paymentTimer'];
            timers.forEach(timerId => {
                const timer = document.getElementById(timerId);
                if (timer) timer.textContent = timeString;
            });

            if (timeLeft <= 300) { // 5 minutes warning
                document.querySelectorAll('.timer-display').forEach(el => {
                    el.style.color = '#dc3545';
                });
            }

            if (timeLeft <= 0) {
                const submitBtn = document.getElementById('submitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Session Expired';
                }
                showMessage('Session expired. Please start a new deposit.', 'error');
                return;
            }

            timeLeft--;
        }

        updateTimers();
        setInterval(updateTimers, 1000);
    }

    // ========================================
    // LOGO FUNCTIONS
    // ========================================

    function loadCryptoLogos() {
        const cryptoLogoContainer = document.getElementById('cryptoLogoContainer');
        if (!cryptoLogoContainer) return;

        const cryptoSymbol = normalizeCryptoSymbol(CONFIG.cryptoName);
        
        const cryptoSymbols = {
            'BTC': '₿', 'ETH': '♦️', 'LTC': 'Ł', 'USDT': '💲',
            'BNB': '🔸', 'ADA': '🎯', 'DOT': '⚫', 'XRP': '💧',
            'SOL': '☀️', 'DOGE': '🐕', 'MATIC': '🔷', 'AVAX': '🏔️',
            'LINK': '🔗', 'UNI': '🦄'
        };

        const symbol = cryptoSymbols[cryptoSymbol] || '🔗';
        cryptoLogoContainer.innerHTML = `<span style="font-size: 32px;">${symbol}</span>`;
    }

    function loadPartnerLogos() {
        const bybitLogo = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iOCIgZmlsbD0iI0Y3OTMxRSIvPgo8dGV4dCB4PSIyMCIgeT0iMjYiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IndoaXRlIiBmb250LXNpemU9IjEwIiBmb250LXdlaWdodD0iYm9sZCI+Qnl8Qml0PC90ZXh0Pgo8L3N2Zz4K";
        const trustWalletLogo = "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iMjAiIGZpbGw9IiMzMzc1QkIiLz4KPHR5cGUgdGV4dD0iVFciIHg9IjIwIiB5PSIyNiIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZmlsbD0id2hpdGUiIGZvbnQtc2l6ZT0iMTIiIGZvbnQtd2VpZ2h0PSJib2xkIi8+Cjwvc3ZnPgo=";

        const bybitLogoEl = document.getElementById('bybitLogo');
        const trustWalletLogoEl = document.getElementById('trustWalletLogo');

        if (bybitLogoEl) bybitLogoEl.src = bybitLogo;
        if (trustWalletLogoEl) trustWalletLogoEl.src = trustWalletLogo;
    }

    // ========================================
    // FORM SUBMISSION HANDLING
    // ========================================

    document.addEventListener('DOMContentLoaded', function() {
        const depositForm = document.getElementById('depositForm');
        const submitBtn = document.getElementById('submitBtn');
        const fileInput = document.getElementById('proof');

        if (!depositForm || !submitBtn || !fileInput) {
            console.error('❌ Form elements not found');
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

            if (!fileInput.files.length) {
                showMessage('Please upload payment proof screenshot', 'error');
                return;
            }

            const file = fileInput.files[0];
            if (!validateFile(file)) return;

            // Update button state
            submitBtn.disabled = true;
            submitBtn.className = 'submitting';
            submitBtn.innerHTML = `<span class="loading-spinner mr-2"></span>Processing...`;

            // Submit form
            submitFormData();
        });

        async function submitFormData() {
            try {
                const formData = new FormData(depositForm);
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
                    submitBtn.innerHTML = `<iconify-icon icon="solar:check-circle-bold" class="mr-2"></iconify-icon>Success!`;
                    submitBtn.style.backgroundColor = '#28a745';
                    
                    showMessage('Deposit submitted successfully! Redirecting...', 'success');
                    
                    setTimeout(() => {
                        window.location.href = '{{ route("user.deposit-history") }}';
                    },  1500);
                    
                } else {
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
                resetSubmitButton();
                showMessage(error.message || 'Failed to submit deposit. Please try again.', 'error');
            }
        }

        function resetSubmitButton() {
            submitBtn.disabled = false;
            submitBtn.className = '';
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
    });

    // ========================================
    // NETWORK STATUS MONITORING
    // ========================================

    window.addEventListener('online', function() {
        globalState.isOnline = true;
        console.log('🌐 Connection restored');
        globalState.retryCount = 0;
        if (!globalState.fetchInProgress) {
            fetchCryptoRateAndCalculate();
        }
    });

    window.addEventListener('offline', function() {
        globalState.isOnline = false;
        console.log('🚫 Connection lost - using cached data');
    });

    // Performance monitoring
    if (typeof performance !== 'undefined') {
        window.addEventListener('load', function() {
            setTimeout(() => {
                const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
                console.log(`⚡ Page loaded in ${loadTime}ms`);
            }, 0);
        });
    }
</script>

@endsection