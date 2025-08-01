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
                            <span id="cryptoAmount" class=""></span>
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
                                    <span id="rateText">Loading current {{ $wallet->crypto_name }} rate...</span>
                                </div>
                                <small id="lastUpdated" class="text-gray-500"></small>
                            </div>
                            <div class="mt-2 text-xs">
                                <span>Network fee: <span id="networkFee">Calculating...</span></span>
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
                                <div class="crypto-logo">
                                    <img id="cryptoLogo" src="" alt="{{ $wallet->crypto_name }} logo">
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
                                            <p class="text-xs text-gray-500">Buy & Trade Crypto</p>
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
   <script>
    const form = document.getElementById("depositForm");
    const submitBtn = document.getElementById("submitBtn");

    form.addEventListener("submit", function () {
        submitBtn.disabled = true;
        submitBtn.textContent = "Submitting...";
        submitBtn.style.backgroundColor = "#ffcc00";
        submitBtn.style.borderColor = "#ffcc00";
        submitBtn.style.color = "#000";
    });
</script>

    @endif
</div>

<script>
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
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const CONFIG = {
            cryptoName: '{{ $wallet->crypto_name }}',
            amountUSD: {
                {
                    $amount
                }
            },
            sessionDuration: 30 * 60,
            updateInterval: 60000
        };

        // Initialize everything
        initializeTimers();
        loadCryptoLogos();
        loadPartnerLogos();
        updateConversionRates();
        setInterval(updateConversionRates, CONFIG.updateInterval);

        function initializeTimers() {
            let timeLeft = CONFIG.sessionDuration;

            function updateTimers() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                document.getElementById('sessionTimer').textContent = timeString;
                document.getElementById('paymentTimer').textContent = timeString;

                if (timeLeft <= 300) {
                    document.querySelectorAll('.timer-display').forEach(el => {
                        el.style.color = '#dc3545';
                    });
                }

                if (timeLeft <= 0) {
                    document.getElementById('submitBtn').disabled = true;
                    return;
                }

                timeLeft--;
            }

            updateTimers();
            setInterval(updateTimers, 1000);
        }

        function loadCryptoLogos() {
            const cryptoName = CONFIG.cryptoName.toLowerCase();
            const cryptoLogo = document.getElementById('cryptoLogo');

            // Multiple logo sources with fallbacks
            const logoSources = [
                `https://cryptologos.cc/logos/${cryptoName}-${cryptoName === 'btc' ? 'bitcoin' : cryptoName}-logo.png`,
                `https://assets.coingecko.com/coins/images/${getCoinGeckoId(cryptoName)}/large/${cryptoName}.png`,
                `https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/32/color/${cryptoName}.png`,
                generateFallbackSVG(CONFIG.cryptoName)
            ];

            loadImageWithFallback(cryptoLogo, logoSources);
        }

        function loadPartnerLogos() {
            const coinbaseLogo = document.getElementById('coinbaseLogo');
            const krakenLogo = document.getElementById('krakenLogo');

            // Coinbase logo sources
            const coinbaseLogos = [
                'https://cryptologos.cc/logos/coinbase-coin-cb-logo.png',
                'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/128/color/cb.png',
                'https://assets.coingecko.com/coins/images/9956/large/4616-cb-icon.png',
                generatePartnerFallbackSVG('CB', '#0052FF')
            ];

            // Kraken logo sources  
            const krakenLogos = [
                'https://cryptologos.cc/logos/kraken-krk-logo.png',
                'https://assets.coingecko.com/coins/images/9760/large/kraken-logo.png',
                'https://cdn.jsdelivr.net/gh/spothq/cryptocurrency-icons@master/128/color/krk.png',
                generatePartnerFallbackSVG('KRK', '#5741D8')
            ];

            loadImageWithFallback(coinbaseLogo, coinbaseLogos);
            loadImageWithFallback(krakenLogo, krakenLogos);
        }

        function loadImageWithFallback(imgElement, sources) {
            let currentIndex = 0;

            function tryNextSource() {
                if (currentIndex < sources.length) {
                    imgElement.src = sources[currentIndex];
                    currentIndex++;
                }
            }

            imgElement.onerror = function() {
                tryNextSource();
            };

            tryNextSource();
        }

        function getCoinGeckoId(cryptoName) {
            const mapping = {
                'btc': '1',
                'eth': '279',
                'ltc': '2',
                'usdt': '825'
            };
            return mapping[cryptoName] || '1';
        }

        function generateFallbackSVG(text) {
            const colors = {
                'BTC': '#F7931A',
                'ETH': '#627EEA',
                'LTC': '#BFBBBB',
                'USDT': '#26A17B'
            };
            const color = colors[text] || '#6B7280';

            return `data:image/svg+xml,${encodeURIComponent(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                <circle cx="24" cy="24" r="24" fill="${color}"/>
                <text x="24" y="30" text-anchor="middle" fill="white" font-size="14" font-weight="bold">${text}</text>
            </svg>
        `)}`;
        }

        function generatePartnerFallbackSVG(text, color) {
            return `data:image/svg+xml,${encodeURIComponent(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                <rect width="48" height="48" rx="8" fill="${color}"/>
                <text x="24" y="30" text-anchor="middle" fill="white" font-size="12" font-weight="bold">${text}</text>
            </svg>
        `)}`;
        }

        async function updateConversionRates() {
            const rateInfo = document.getElementById('rateInfo');
            const rateText = document.getElementById('rateText');
            const cryptoAmount = document.getElementById('cryptoAmount');
            const networkFee = document.getElementById('networkFee');
            const lastUpdated = document.getElementById('lastUpdated');

            try {
                rateInfo.className = 'rate-info loading';
                rateText.innerHTML = '<span class="loading-spinner mr-2"></span>Fetching current ' + CONFIG.cryptoName + ' rate...';

                const rates = await fetchCryptoRates(CONFIG.cryptoName);

                // Update display
                cryptoAmount.textContent = rates.cryptoAmount;
                networkFee.textContent = `$${rates.networkFee.min} - $${rates.networkFee.max}`;

                rateInfo.className = 'rate-info';
                rateText.innerHTML = `
                <strong>1 ${CONFIG.cryptoName} = $${rates.price.toLocaleString()}</strong> 
                <small class="text-gray-500">(via ${rates.source})</small>
            `;
                lastUpdated.textContent = `Updated: ${new Date().toLocaleTimeString()}`;

            } catch (error) {
                console.error('Rate fetch error:', error);
                rateInfo.className = 'rate-info error';
                rateText.innerHTML = `<iconify-icon icon="solar:danger-triangle-outline" class="mr-1"></iconify-icon>Failed to fetch current rates. Using fallback data.`;

                // Use fallback rates
                const fallbackRate = getFallbackRate(CONFIG.cryptoName);
                const fallbackAmount = (CONFIG.amountUSD / fallbackRate).toFixed(8);
                cryptoAmount.textContent = fallbackAmount;
                networkFee.textContent = '$2.50 - $8.00';
            }
        }

        async function fetchCryptoRates(cryptoName) {
            const coinMapping = {
                'BTC': 'bitcoin',
                'ETH': 'ethereum',
                'LTC': 'litecoin',
                'USDT': 'tether'
            };

            const coinId = coinMapping[cryptoName.toUpperCase()] || 'bitcoin';

            // Use CoinGecko API with CORS proxy
            const apiUrl = `https://api.coingecko.com/api/v3/simple/price?ids=${coinId}&vs_currencies=usd&include_24hr_change=true`;

            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error('API request failed');

            const data = await response.json();
            const price = data[coinId]?.usd;

            if (!price) throw new Error('Price data not available');

            const networkFees = {
                'BTC': {
                    min: 2.50,
                    max: 8.00
                },
                'ETH': {
                    min: 1.00,
                    max: 5.00
                },
                'LTC': {
                    min: 0.10,
                    max: 0.50
                },
                'USDT': {
                    min: 1.00,
                    max: 5.00
                }
            };

            const fee = networkFees[cryptoName.toUpperCase()] || networkFees['BTC'];
            const cryptoAmount = (CONFIG.amountUSD / price).toFixed(8);

            return {
                price,
                cryptoAmount,
                networkFee: fee,
                source: 'CoinGecko'
            };
        }

        function getFallbackRate(cryptoName) {
            const fallbackRates = {
                'BTC': 115062, // Current BTC rate as mentioned
                'ETH': 2800,
                'LTC': 150,
                'USDT': 1.00
            };
            return fallbackRates[cryptoName.toUpperCase()] || 115062;
        }

        // File upload handling
        const fileInput = document.getElementById('proof');
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const fileError = document.getElementById('fileError');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (validateFile(file)) {
                    fileNameDisplay.querySelector('#fileNameText').textContent = `${file.name} (${formatFileSize(file.size)})`;
                    fileNameDisplay.classList.remove('hidden');
                    fileError.classList.add('hidden');
                }
            } else {
                fileNameDisplay.classList.add('hidden');
            }
        });

        function validateFile(file) {
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
            const maxSize = 5 * 1024 * 1024; // 5MB

            if (!allowedTypes.includes(file.type)) {
                fileError.textContent = 'Invalid file type. Please upload PNG, JPG, or PDF files only.';
                fileError.classList.remove('hidden');
                return false;
            }

            if (file.size > maxSize) {
                fileError.textContent = 'File too large. Maximum size is 5MB.';
                fileError.classList.remove('hidden');
                return false;
            }

            return true;
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Drag and drop functionality
        const uploadArea = document.getElementById('uploadArea');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        uploadArea.addEventListener('drop', handleDrop, false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            uploadArea.classList.add('dragover');
        }

        function unhighlight(e) {
            uploadArea.classList.remove('dragover');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
            }
        }

        // Form submission handling
        const depositForm = document.getElementById('depositForm');
        const submitBtn = document.getElementById('submitBtn');

        depositForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!fileInput.files.length) {
                fileError.textContent = 'Please upload payment proof.';
                fileError.classList.remove('hidden');
                return;
            }

            const file = fileInput.files[0];
            if (!validateFile(file)) {
                return;
            }

            // Disable submit button and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
            <div class="loading-spinner mr-2"></div>
            Processing...
        `;

            try {
                const formData = new FormData(depositForm);

                const response = await fetch(depositForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });

                if (response.ok) {
                    const result = await response.json();

                    if (result.success) {
                        showSuccessMessage('Deposit submitted successfully! Redirecting...');
                        setTimeout(() => {
                            window.location.href = result.redirect || '{{ route("user_dashboard") }}';
                        }, 2000);
                    } else {
                        throw new Error(result.message || 'Submission failed');
                    }
                } else {
                    throw new Error('Server error occurred');
                }

            } catch (error) {
                console.error('Submission error:', error);
                showErrorMessage(error.message || 'Failed to submit deposit. Please try again.');

                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = `
                <iconify-icon icon="solar:card-transfer-linear" class="text-base"></iconify-icon>
                Confirm Deposit
            `;
            }
        });

        function showSuccessMessage(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg';
            alertDiv.innerHTML = `
            <div class="flex items-center">
                <iconify-icon icon="solar:check-circle-bold" class="mr-2"></iconify-icon>
                <span>${message}</span>
            </div>
        `;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        function showErrorMessage(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-4 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg';
            alertDiv.innerHTML = `
            <div class="flex items-center">
                <iconify-icon icon="solar:danger-triangle-bold" class="mr-2"></iconify-icon>
                <span>${message}</span>
            </div>
        `;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Handle page visibility change to update rates when page becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                updateConversionRates();
            }
        });

        // Add warning before page unload if file is selected but not submitted
        window.addEventListener('beforeunload', function(e) {
            const hasUnsavedFile = fileInput.files.length > 0;

            if (hasUnsavedFile && !submitBtn.disabled) {
                e.preventDefault();
                e.returnValue = 'You have selected a file but haven\'t submitted the deposit. Are you sure you want to leave?';
                return e.returnValue;
            }
        });
    });
</script>

@endsection