@extends('layout.user')

@section('content')
<!-- Authentication Overlay - Will persist until closed -->

<!-- Place this in your Blade file (e.g. dashboard.blade.php) -->
<!-- Certificate Overlay -->
<div class="main-content">
   @php
    $shouldResetOverlay = session()->pull('clearCertOverlay', false);
@endphp

<div
    x-data="{
        showOverlay: false,
        closedThisSession: false,
        overlayCountToday: {{ $overlayCountToday }},
        shouldReset: {{ $shouldResetOverlay ? 'true' : 'false' }},

        init() {
            if (this.shouldReset) {
                sessionStorage.removeItem('overlayClosed');
            }

            this.closedThisSession = sessionStorage.getItem('overlayClosed') === 'true';

            setTimeout(() => {
                if (!this.closedThisSession && this.overlayCountToday < 2) {
                    this.showOverlay = true;
                }
            }, 60000); // show after 1 minute
        },

        closeOverlay() {
            this.showOverlay = false;
            this.closedThisSession = true;
            sessionStorage.setItem('overlayClosed', 'true');

            fetch('/certificate-shown', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
            }).then(() => {
                this.overlayCountToday++;
            });
        }
    }"
    x-init="init()"
    x-show="showOverlay"
    x-cloak
    class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center px-4"
    style="backdrop-filter: blur(4px);"
    @click.away="closeOverlay()"
>
    <div class="relative w-full max-w-3xl text-center p-4">
        <img  loading="lazy" 

            src="{{ asset('assets/images/certificate.jpg') }}"
            alt="Official Certification"
            class="mx-auto object-contain rounded-lg shadow-2xl"
            style="max-height: 60vh; max-width: 80%; width: auto;" />
        <div class="mt-2 space-y-2 px-4">
            <p class="text-base text-[#0C3A30] font-medium">
                Recognized <span class="font-semibold">Government</span> Approved Certification
            </p>
        </div>
        <button
            @click="closeOverlay"
            class="hover:text-red-500 text-[140px] font-bold rounded-full p-1 z-50 transition-all"
            style="width: 2.5rem; height: 2.5rem; color: #8bc905; background-color: #0C3A30; box-shadow: 0 0 15px rgba(139, 201, 5, 0.64);"
        >&times;</button>
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>




    <!-- Rest of your template remains exactly the same -->
    <!-- Main Dashboard Content -->
    <div class="dashboard-main-body space-y-6" style="background-image: url(assets/images/hero/hero-image-1.svg); padding-top: -20rem;">

        <!-- Header with Breadcrumb -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-[#f0fdf4] px-2 py-3 rounded-lg shadow-sm w-full sm:w-auto">
                <div class="relative">
                    @php
                    $profilePic = $user->profile->profile_pic ?? null;
                    $hasProfilePic = $profilePic && file_exists(public_path('uploads/' . $profilePic));
                    $initials = collect(explode(' ', $user->name))
                    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                    ->take(2)
                    ->join('') ?: 'U';
                    @endphp

                    @if ($hasProfilePic)
                    <img
                        src="{{ asset('uploads/' . $profilePic) }}"
                        alt="{{ $user->name }}"
                        class="rounded-full object-cover"
                        style="width: 5rem; height: 5rem;" />
                    @else
                    <div
                        class="flex items-center justify-center font-bold text-2xl text-[#0C3A30] select-none"
                        style="background-color: #8bc905; width: 5rem; height: 5rem; border-radius: 9999px;">
                        {{ $initials }}
                    </div>
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-lg font-semibold dark:text-[#9edd05]" style="color: #0C3A30;">
                            Hi, {{ auth()->user()->name ?? 'Guest' }}
                        </h1>
                        <!-- Verification Icon -->
                        <div class="verified-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-sm" style="color: #0C3A30; display:flex; flex-wrap: nowrap;">
                        Here is a summary of your account.
                    </h2>
                    <h2 class="text-sm" style="color: #0C3A30;"> Have fun!</h2>
                </div>
            </div>
        </div>

        <!-- Dashboard Navigation -->
        <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
            <h6 class="font-semibold mb-0" style="color: #0C3A30;">Dashboard</h6>
            <ul class="flex items-center gap-[6px]">
                <li class="font-medium">
                    <a href="{{ route('user_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600 dark:text-white" onmouseover="this.style.backgroundColor='transparent'; this.style.color='#9EDD05';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0C3A30';">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li class="dark:text-white">-</li>
                <li class="font-medium dark:text-white" style="color: #9EDD05;">MarketMind</li>
            </ul>
        </div>

        <!-- Initialize Alpine.js data -->
        <div x-data="{
            showBalance: localStorage.getItem('showBalance') === 'true',
            toggleBalance() {
                this.showBalance = !this.showBalance;
                localStorage.setItem('showBalance', this.showBalance);
            }
        }">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Available Balance Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden dark:border-primary-800"
                    style="border-top: 4px solid #8bc905; background-image: url('assets/images/hero/hero-image-1.svg'); background-size: cover; background-position: center;">
                    <div class="p-6 bg-white/90 dark:bg-gray-800/90 rounded-2xl">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium">Available Balance</p>
                                <h3 class="text-2xl font-bold text-primary-800 dark:text-white mt-1">
                                    <template x-if="showBalance">
                                        <span>${{ number_format(auth()->user()->total_income, 2) }}</span>
                                    </template>
                                    <template x-if="!showBalance">
                                        <span class="text-xl">••••••••</span>
                                    </template>
                                </h3>
                            </div>
                            <div class="p-3 rounded-xl" style="color:#0C3A30;">
                                <button @click="toggleBalance" class="flex items-center gap-1 text-xs mt-2 text-[#0C3A30] hover:text-[#9EDD05] transition-colors">
                                    <iconify-icon x-bind:icon="showBalance ? 'mdi:eye-off' : 'mdi:eye'" class="text-2xl"></iconify-icon>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 " style="border-top: 1px solid#0C3A30;">
                            <h6 class="text-xs mt-2">Invested + Interest</h6>
                        </div>
                    </div>
                </div>

                <!-- Total Invested Card -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-emerald-200 dark:border-emerald-800"
                    style="border-top: 4px solid #8bc905; background-image: url('assets/images/hero/hero-image-1.svg'); background-size: cover; background-position: center;">
                    <div class="p-6 bg-white/90 dark:bg-gray-800/90 rounded-2xl">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium">Total Invested With Us</p>
                                <h3 class="text-2xl font-bold text-[#0C3A30] mt-1">
                                    <template x-if="showBalance">
                                        <span>${{ number_format($totalInvested, 2) }}</span>
                                    </template>
                                    <template x-if="!showBalance">
                                        <span class="text-xl">••••••••</span>
                                    </template>
                                </h3>
                            </div>
                            <div class="p-3 rounded-xl" style="color: #9EDD05;">
                                <iconify-icon icon="fa-solid:award" class="text-2xl"></iconify-icon>
                            </div>
                        </div>
                        <div class="mt-6 pt-2" style="border-top: 1px solid#0C3A30;">
                            <h6 class="text-xs mt-2">Across all investments</h6>
                        </div>
                    </div>
                </div>
                <!-- Quick Actions Card -->
                <div class="bg-gradient-to-br from-primary-800 via-primary-700 to-primary-600 text-white rounded-2xl shadow-xl overflow-hidden" style="border-top: 4px solid #8bc905; background-image: url('assets/images/hero/hero-image-1.svg'); background-size: cover; background-position: center;">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Quick Actions</p>
                        <div class="flex quick-actions-buttons gap-3">
                               <a href="{{ route('user.deposit') }}"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-3 custom-hover-deposit"
                                style="border-top: 4px solid #8bc905;">
                                <iconify-icon icon="solar:wallet-outline" class="text-lg"></iconify-icon>
                                Deposit
                            </a>
                            <a href="{{ route('user.withdraw.form') }}"
                                class="flex-1 flex items-center justify-center gap-2 px-4 py-3 font-semibold rounded-lg transition-all shadow-sm"
                                style="background-color: #8bc905; color: #0C3A30; text-decoration: none;"
                                onmouseover="this.style.backgroundColor='#7dbb00'"
                                onmouseout="this.style.backgroundColor='#8bc905'">
                                <iconify-icon icon="solar:wallet-money-outline" class="text-xl"></iconify-icon>
                                Withdraw
                            </a>

                         
                        </div>
                    </div>
                </div>
                <style>
                    .quick-actions-buttons {
                        flex-direction: row;
                        /* Default: horizontal */
                    }

                    /* Tablets and smaller: stack vertically */
                    @media (max-width: 1024px) {
                        .quick-actions-buttons {
                            flex-direction: column;
                        }

                        .quick-actions-buttons>a {
                            width: 100%;
                            /* Full width buttons */
                            margin-bottom: 0.75rem;
                            /* spacing between buttons */
                        }

                        .quick-actions-buttons>a:last-child {
                            margin-bottom: 0;
                            /* Remove bottom margin on last button */
                        }
                    }
                </style>
            </div>

            <!-- Activity Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Recent Activity -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-100 dark:border-gray-700" style="background-image: url(assets/images/hero/hero-image-1.svg); background-size: cover; background-position: center;">
                    <h3 class="text-lg font-bold text-primary-800 dark:text-white mb-6">Recent Activity</h3>
                    <div class="space-y-4 h-[65vh] min-h-[400px] max-h-[700px] overflow-y-auto w-full pr-2">
                        @forelse ($recentActivities as $activity)
                        @php
                        $baseColor = match($activity['type']) {
                        'Deposit' => 'emerald',
                        'Withdrawal' => 'red',
                        default => 'gray'
                        };

                        $isPending = strtolower($activity['status']) === 'pending';
                        $statusText = $isPending ? 'Pending' : 'Approved';
                        $statusBg = $isPending ? 'bg-yellow-100 dark:bg-yellow-600/25' : 'bg-green-100 dark:bg-green-600/25';
                        $statusTextColor = $isPending ? 'text-yellow-800 dark:text-yellow-300' : 'text-green-800 dark:text-green-300';
                        $isDeposit = $activity['type'] === 'Deposit';
                        @endphp

                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors max-w-full">
                            <div class="flex items-center gap-4">
                                <div class="bg-{{ $baseColor }}-100 dark:bg-{{ $baseColor }}-900/30 p-3 rounded-lg">
                                    <iconify-icon icon="mdi:{{ $activity['icon'] }}" class="text-{{ $baseColor }}-600 dark:text-{{ $baseColor }}-400 text-xl"></iconify-icon>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $activity['type'] }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $activity['date']->format('M d, h:i A') }}</p>
                                    <p class="text-xs text-gray-400">{{ $activity['reference'] }}</p>
                                </div>
                            </div>
                            <div class="text-right space-y-1">
                                <template x-if="showBalance">
                                    <p class="font-medium text-{{ $baseColor }}-600 dark:text-{{ $baseColor }}-400">
                                        {{ $isDeposit ? '+' : '-' }}${{ number_format($activity['amount'], 2) }}
                                    </p>
                                </template>
                                <template x-if="!showBalance">
                                    <p class="font-medium text-{{ $baseColor }}-600 dark:text-{{ $baseColor }}-400">
                                        ••••••••
                                    </p>
                                </template>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusBg }} {{ $statusTextColor }}">
                                    {{ $statusText }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm">No recent activity available.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Market Charts -->
                <div>
                    <!-- TradingView Widget -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 pb-3">
                        <h2 class="text-lg font-bold text-[#0C3A30] dark:text-white mb-4">Live Market Charts (Crypto, Forex, Stocks, Metaverse etc...)</h2>
                        <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
                                {
                                    "colorTheme": "light",
                                    "dateRange": "12M",
                                    "showChart": true,
                                    "locale": "en",
                                    "width": "100%",
                                    "height": "400",
                                    "largeChartUrl": "",
                                    "isTransparent": false,
                                    "showSymbolLogo": true,
                                    "plotLineColorGrowing": "#8bc905",
                                    "plotLineColorFalling": "#f23645",
                                    "gridLineColor": "rgba(240, 240, 240, 0.3)",
                                    "scaleFontColor": "#0C3A30",
                                    "belowLineFillColorGrowing": "rgba(139, 201, 5, 0.1)",
                                    "belowLineFillColorFalling": "rgba(242, 54, 69, 0.1)",
                                    "symbolActiveColor": "#9EDD05",
                                    "tabs": [{
                                            "title": "Crypto",
                                            "symbols": [{
                                                    "s": "BINANCE:BTCUSDT",
                                                    "d": "Bitcoin"
                                                },
                                                {
                                                    "s": "BINANCE:ETHUSDT",
                                                    "d": "Ethereum"
                                                },
                                                {
                                                    "s": "BINANCE:SOLUSDT",
                                                    "d": "Solana"
                                                },
                                                {
                                                    "s": "BINANCE:XRPUSDT",
                                                    "d": "XRP"
                                                },
                                                {
                                                    "s": "BINANCE:BNBUSDT",
                                                    "d": "BNB"
                                                },
                                                {
                                                    "s": "BINANCE:ADAUSDT",
                                                    "d": "Cardano"
                                                },
                                                {
                                                    "s": "BINANCE:DOGEUSDT",
                                                    "d": "Dogecoin"
                                                },
                                                {
                                                    "s": "BINANCE:MATICUSDT",
                                                    "d": "Polygon"
                                                },
                                                {
                                                    "s": "BINANCE:AVAXUSDT",
                                                    "d": "Avalanche"
                                                },
                                                {
                                                    "s": "BINANCE:DOTUSDT",
                                                    "d": "Polkadot"
                                                }
                                            ]
                                        },
                                        {
                                            "title": "Forex",
                                            "symbols": [{
                                                    "s": "FX:EURUSD",
                                                    "d": "EUR/USD"
                                                },
                                                {
                                                    "s": "FX:GBPUSD",
                                                    "d": "GBP/USD"
                                                },
                                                {
                                                    "s": "FX:USDJPY",
                                                    "d": "USD/JPY"
                                                },
                                                {
                                                    "s": "FX:AUDUSD",
                                                    "d": "AUD/USD"
                                                },
                                                {
                                                    "s": "FX:USDCAD",
                                                    "d": "USD/CAD"
                                                },
                                                {
                                                    "s": "FX:NZDUSD",
                                                    "d": "NZD/USD"
                                                },
                                                {
                                                    "s": "FX:USDCHF",
                                                    "d": "USD/CHF"
                                                },
                                                {
                                                    "s": "FX:EURJPY",
                                                    "d": "EUR/JPY"
                                                },
                                                {
                                                    "s": "FX:GBPJPY",
                                                    "d": "GBP/JPY"
                                                },
                                                {
                                                    "s": "FX:EURGBP",
                                                    "d": "EUR/GBP"
                                                }
                                            ]
                                        },
                                        {
                                            "title": "Real Estate",
                                            "symbols": [{
                                                    "s": "NYSE:VNQ",
                                                    "d": "Vanguard REIT ETF"
                                                },
                                                {
                                                    "s": "NYSE:O",
                                                    "d": "Realty Income Corp"
                                                },
                                                {
                                                    "s": "NYSE:PLD",
                                                    "d": "Prologis"
                                                },
                                                {
                                                    "s": "NYSE:AMT",
                                                    "d": "American Tower"
                                                },
                                                {
                                                    "s": "NYSE:EQIX",
                                                    "d": "Equinix"
                                                },
                                                {
                                                    "s": "NYSE:SPG",
                                                    "d": "Simon Property Group"
                                                },
                                                {
                                                    "s": "NYSE:AVB",
                                                    "d": "AvalonBay Communities"
                                                },
                                                {
                                                    "s": "NYSE:WELL",
                                                    "d": "Welltower"
                                                },
                                                {
                                                    "s": "NYSE:DLR",
                                                    "d": "Digital Realty Trust"
                                                },
                                                {
                                                    "s": "NYSE:PSA",
                                                    "d": "Public Storage"
                                                }
                                            ]
                                        },
                                        {
                                            "title": "Stocks",
                                            "symbols": [{
                                                    "s": "NASDAQ:AAPL",
                                                    "d": "Apple"
                                                },
                                                {
                                                    "s": "NASDAQ:MSFT",
                                                    "d": "Microsoft"
                                                },
                                                {
                                                    "s": "NASDAQ:GOOGL",
                                                    "d": "Alphabet"
                                                },
                                                {
                                                    "s": "NASDAQ:AMZN",
                                                    "d": "Amazon"
                                                },
                                                {
                                                    "s": "NASDAQ:META",
                                                    "d": "Meta"
                                                },
                                                {
                                                    "s": "NYSE:TSLA",
                                                    "d": "Tesla"
                                                },
                                                {
                                                    "s": "NYSE:NVDA",
                                                    "d": "NVIDIA"
                                                },
                                                {
                                                    "s": "NYSE:BRK.B",
                                                    "d": "Berkshire Hathaway"
                                                },
                                                {
                                                    "s": "NYSE:JPM",
                                                    "d": "JPMorgan Chase"
                                                },
                                                {
                                                    "s": "NYSE:V",
                                                    "d": "Visa"
                                                }
                                            ]
                                        },
                                        {
                                            "title": "Travel & Booking",
                                            "symbols": [{
                                                    "s": "NYSE:ABNB",
                                                    "d": "Airbnb"
                                                },
                                                {
                                                    "s": "NASDAQ:EXPE",
                                                    "d": "Expedia"
                                                },
                                                {
                                                    "s": "NYSE:BOOK",
                                                    "d": "Booking Holdings"
                                                },
                                                {
                                                    "s": "NYSE:MAR",
                                                    "d": "Marriott Hotels"
                                                },
                                                {
                                                    "s": "NYSE:HLT",
                                                    "d": "Hilton Hotels"
                                                },
                                                {
                                                    "s": "NYSE:AAL",
                                                    "d": "American Airlines"
                                                },
                                                {
                                                    "s": "NYSE:DAL",
                                                    "d": "Delta Airlines"
                                                },
                                                {
                                                    "s": "NASDAQ:UBER",
                                                    "d": "Uber (Rideshares)"
                                                }
                                            ]
                                        },
                                        {
                                            "title": "Gift Cards & Payments",
                                            "symbols": [{
                                                    "s": "NYSE:GCT",
                                                    "d": "GiftCardMall (Gift Cards)"
                                                },
                                                {
                                                    "s": "NASDAQ:PYPL",
                                                    "d": "PayPal (Digital Payments)"
                                                },
                                                {
                                                    "s": "NYSE:SQ",
                                                    "d": "Block (Cash App)"
                                                },
                                                {
                                                    "s": "NASDAQ:COIN",
                                                    "d": "Coinbase (Crypto Gift Cards)"
                                                },
                                                {
                                                    "s": "NYSE:V",
                                                    "d": "Visa (Gift Card Partner)"
                                                },
                                                {
                                                    "s": "NYSE:MA",
                                                    "d": "Mastercard (Gift Cards)"
                                                }
                                            ]
                                        },
                                        {
                                            "title": "Luxury & Vacation",
                                            "symbols": [{
                                                    "s": "NYSE:LVS",
                                                    "d": "Las Vegas Sands (Resorts)"
                                                },
                                                {
                                                    "s": "NYSE:RCL",
                                                    "d": "Royal Caribbean (Cruises)"
                                                },
                                                {
                                                    "s": "NYSE:CCL",
                                                    "d": "Carnival Corp (Cruises)"
                                                },
                                                {
                                                    "s": "NYSE:TNL",
                                                    "d": "Travel + Leisure Co"
                                                },
                                                {
                                                    "s": "NYSE:H",
                                                    "d": "Hyatt Hotels"
                                                }
                                            ]
                                        },
                                        {
                                            "title": "Metaverse Real Estate",
                                            "symbols": [{
                                                    "s": "BINANCE:SANDUSDT",
                                                    "d": "The Sandbox (Virtual Land)"
                                                },
                                                {
                                                    "s": "BINANCE:MANAUSDT",
                                                    "d": "Decentraland (Virtual Real Estate)"
                                                },
                                                {
                                                    "s": "NASDAQ:META",
                                                    "d": "Meta (VR Real Estate)"
                                                },
                                                {
                                                    "s": "NYSE:U",
                                                    "d": "Unity (3D Virtual Spaces)"
                                                }
                                            ]
                                        },
                                        {
                                            "title": "Commodities",
                                            "symbols": [{
                                                    "s": "TVC:USOIL",
                                                    "d": "Crude Oil"
                                                },
                                                {
                                                    "s": "TVC:GOLD",
                                                    "d": "Gold"
                                                },
                                                {
                                                    "s": "TVC:SILVER",
                                                    "d": "Silver"
                                                },
                                                {
                                                    "s": "TVC:NATURALGAS",
                                                    "d": "Natural Gas"
                                                },
                                                {
                                                    "s": "TVC:COPPER",
                                                    "d": "Copper"
                                                },
                                                {
                                                    "s": "TVC:PLATINUM",
                                                    "d": "Platinum"
                                                },
                                                {
                                                    "s": "TVC:PALLADIUM",
                                                    "d": "Palladium"
                                                },
                                                {
                                                    "s": "TVC:CORN",
                                                    "d": "Corn"
                                                },
                                                {
                                                    "s": "TVC:WHEAT",
                                                    "d": "Wheat"
                                                },
                                                {
                                                    "s": "TVC:SOYBEAN",
                                                    "d": "Soybean"
                                                }
                                            ]
                                        },
                                        {
                                            "title": "Indices",
                                            "symbols": [{
                                                    "s": "FOREXCOM:SPXUSD",
                                                    "d": "S&P 500"
                                                },
                                                {
                                                    "s": "FOREXCOM:DJI",
                                                    "d": "Dow Jones"
                                                },
                                                {
                                                    "s": "NASDAQ:NDX",
                                                    "d": "Nasdaq 100"
                                                },
                                                {
                                                    "s": "FOREXCOM:NSXUSD",
                                                    "d": "Nasdaq Composite"
                                                },
                                                {
                                                    "s": "FOREXCOM:UK100",
                                                    "d": "FTSE 100"
                                                },
                                                {
                                                    "s": "FOREXCOM:DE30EUR",
                                                    "d": "DAX"
                                                },
                                                {
                                                    "s": "FOREXCOM:FR40EUR",
                                                    "d": "CAC 40"
                                                },
                                                {
                                                    "s": "FOREXCOM:EU50EUR",
                                                    "d": "Euro Stoxx 50"
                                                },
                                                {
                                                    "s": "FOREXCOM:HK50HKD",
                                                    "d": "Hang Seng"
                                                },
                                                {
                                                    "s": "FOREXCOM:JP225USD",
                                                    "d": "Nikkei 225"
                                                }
                                            ]
                                        },
                                        {
                                            "title": "Trending",
                                            "symbols": [{
                                                    "s": "BINANCE:SHIBUSDT",
                                                    "d": "Shiba Inu"
                                                },
                                                {
                                                    "s": "BINANCE:TRXUSDT",
                                                    "d": "Tron"
                                                },
                                                {
                                                    "s": "BINANCE:NEARUSDT",
                                                    "d": "Near Protocol"
                                                },
                                                {
                                                    "s": "BINANCE:LINKUSDT",
                                                    "d": "Chainlink"
                                                },
                                                {
                                                    "s": "BINANCE:ATOMUSDT",
                                                    "d": "Cosmos"
                                                },
                                                {
                                                    "s": "BINANCE:ALGOUSDT",
                                                    "d": "Algorand"
                                                },
                                                {
                                                    "s": "BINANCE:APTUSDT",
                                                    "d": "Aptos"
                                                },
                                                {
                                                    "s": "BINANCE:HBARUSDT",
                                                    "d": "Hedera"
                                                },
                                                {
                                                    "s": "BINANCE:VETUSDT",
                                                    "d": "VeChain"
                                                },
                                                {
                                                    "s": "BINANCE:FTMUSDT",
                                                    "d": "Fantom"
                                                }
                                            ]
                                        }
                                    ]
                                }
                            </script>
                        </div>
                    </div>

                    <!-- Motivational Quote -->
                    <div x-data="quoteRotator()" x-init="startRotation()" class="relative rounded-2xl overflow-hidden shadow-2xl min-h-[240px] flex items-center justify-center text-center text-white pt-3">


                        <div class="absolute inset-0 bg-[#0C3A30]/80 backdrop-blur-sm" style="background-image: url('https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1350&q=80'); padding-top:8rem"></div>
                        <div class="absolute inset-0 bg-primary-900/80"></div>
                        <div class="relative z-10 max-w-2xl px-4 sm:px-8">
                            <div x-transition:enter="transition-opacity duration-700"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition-opacity duration-500"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0">
                                <p class="text-white text-xl sm:text-2xl font-semibold italic leading-relaxed" x-text="quotes[currentIndex].quote"></p>
                                <p class="text-primary-200 text-sm mt-4" x-text="quotes[currentIndex].author"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Close Alpine.js data scope -->

        <!-- Language Selector -->
        <div class="languageTranslateWrapper flex items-center gap-1 pl-2 pr-2 py-1">
            <div class="languageTranslate" id="google_translate_element">🌐</div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function quoteRotator() {
            return {
                quotes: [{
                        quote: '"Compound interest is the eighth wonder of the world. He who understands it, earns it; he who doesn\'t, pays it."',
                        author: '- Albert Einstein'
                    },
                    {
                        quote: '"The stock market is filled with individuals who know the price of everything, but the value of nothing."',
                        author: '- Philip Fisher'
                    },
                    {
                        quote: '"Do not save what is left after spending, but spend what is left after saving."',
                        author: '- Warren Buffett'
                    }
                ],
                currentIndex: 0,
                startRotation() {
                    setInterval(() => {
                        this.currentIndex = (this.currentIndex + 1) % this.quotes.length;
                    }, 6000);
                }
            }
        }
    </script>

    <!-- Google Translate Script -->




    <style>
        /* GENERAL CONTAINER FIXES */
        @media screen and (max-width: 1200px) and (min-width: 768px) {
            .dashboard-main-body {
                padding: 2rem 1.5rem;
            }

            .quick-actions-buttons {
                flex-direction: column;
            }

            .quick-actions-buttons>a {
                width: 100%;
                margin-bottom: 0.75rem;
            }

            .quick-actions-buttons>a:last-child {
                margin-bottom: 0;
            }
        }

        /* STAT CARD FIX */
        @media screen and (max-width: 1200px) and (min-width: 768px) {
            .stat-card {
                min-height: 220px;
                background-size: cover;
                background-position: center;
            }

            .stat-card-inner {
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 1.5rem;
                background-color: rgba(255, 255, 255, 0.92);
                border-radius: 1rem;
            }

            .card-top-border {
                border-top: 3px solid #8bc905 !important;
            }

            .card-inner-border {
                border-top: 2px solid #0C3A30;
                padding-top: 1rem;
                margin-top: 1rem;
            }

            .card-inner-border.dark {
                border-top: 2px solid #9EDD05;
            }
        }

        /* FIX TEXT AND HEADINGS ON TABLET */
        @media screen and (max-width: 1200px) {

            h3,
            h2,
            h1 {
                font-size: 1.25rem;
            }

            p,
            h6 {
                font-size: 0.875rem;
            }
        }

        /* TRADINGVIEW AND QUOTES */
        @media screen and (max-width: 768px) {
            .tradingview-widget-container iframe {
                height: 350px !important;
            }

            .quote-box {
                padding: 1rem;
            }


        }

        /* Default: no margin on small screens (mobile) */
        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }

        /* Only on mid-sized screens (like fold phones / tablets) */
        @media screen and (min-width: 1024px) and (max-width: 1199px) {
            .main-content {
                margin-left: 260px;
                /* Push content to avoid being hidden by sidebar */
            }
        }
    </style>
</div>
@endsection