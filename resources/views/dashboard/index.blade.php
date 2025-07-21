@extends('layout.user')

@section('content')
<!-- Certificate Overlay -->
<div class="main-content" style="background-image: url(assets/images/hero/hero-image-1.svg); min-height: 100vh; background-size: cover; color:#0C3A30;">

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
            }, 60000);
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
        @click.away="closeOverlay()">
        <div class="relative w-full max-w-3xl text-center p-4">
            <img loading="lazy"
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
                style="width: 2.5rem; height: 2.5rem; color: #8bc905; background-color: #0C3A30; box-shadow: 0 0 15px rgba(139, 201, 5, 0.64);">&times;</button>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Main Dashboard Content -->
    <div class="dashboard-main-body space-y-6" style="min-height: 100vh; background-image: url(assets/images/hero/hero-image-1.svg); background-size: cover;">

        <!-- Header with Breadcrumb -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-[#f0fdf4] px-2 py-3 rounded-lg shadow-sm w-full sm:w-auto">
                <div class="relative">
                    @php
                    $profilePic = $user->profile->profile_pic ?? null;
                    $storagePath = storage_path('app/public/profile_pictures/' . $profilePic);
                    $hasProfilePic = $profilePic && file_exists($storagePath);

                    $initials = collect(explode(' ', $user->name))
                    ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                    ->take(2)
                    ->join('') ?: 'U';
                    @endphp

                    @if ($hasProfilePic)
                    <img
                        src="{{ asset('storage/profile_pictures/' . $profilePic) }}?v={{ filemtime($storagePath) }}"
                        alt="{{ $user->name }}"
                        class="rounded-full object-cover"
                        style="width: 80px; height: 80px; border: 2px solid #8bc905; border-radius:50%; " />
                    @else
                    <div
                        class="flex items-center justify-center font-bold text-2xl text-[#0C3A30] select-none"
                        style="background-color: #8bc905; width: 80px; height: 80px; ">
                        {{ $initials }}
                    </div>
                    @endif

                </div>

                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-lg font-semibold" style="color: #0C3A30;">
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
                    <a href="{{ route('user_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600 " onmouseover="this.style.backgroundColor='transparent'; this.style.color='#9EDD05';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0C3A30';">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="font-medium " style="color: #9EDD05;">MarketMind</li>
            </ul>
        </div>

        <!-- Initialize Alpine.js data -->
        <div x-data="{
            showBalance: localStorage.getItem('showBalance') === 'true',
            toggleBalance() {
                this.showBalance = !this.showBalance;
                localStorage.setItem('showBalance', this.showBalance);
            },
            initBalances: {
                available: {{ auth()->user()->total_income ?? 0 }},
                invested: {{ $totalInvested ?? 0 }},
                loaded: false
            },
            init() {
                // Simulate loading delay (remove in production)
                setTimeout(() => {
                    this.initBalances.loaded = true;
                }, 300);
            }
        }">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Available Balance Card -->
                <div class=" rounded-2xl shadow-xl overflow-hidden min-h-[150px]"
                    style="border-top: 4px solid #8bc905; background-image: url('assets/images/hero/hero-image-1.svg'); background-size: cover; background-position: center;">
                    <div class="p-6  rounded-2xl">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium">Available Balance</p>
                                <template x-if="!initBalances.loaded">
                                    <div class="h-8 w-40 mt-2 bg-gray-200 rounded animate-pulse"></div>
                                </template>
                                <template x-if="initBalances.loaded">
                                    <h3 class="text-2xl font-bold text-primary-800 mt-1">
                                        <template x-if="showBalance">
                                            <span x-text="'$' + initBalances.available.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                                        </template>
                                        <template x-if="!showBalance">
                                            <span class="text-xl">••••••••</span>
                                        </template>
                                    </h3>
                                </template>
                            </div>

                            
                            <div class="p-3 rounded-xl" style="color:#0C3A30;">
                                <button @click="toggleBalance" class="flex items-center gap-1 text-xs mt-2 text-[#0C3A30] hover:text-[#9EDD05] transition-colors">
                                    <iconify-icon x-bind:icon="showBalance ? 'mdi:eye-off' : 'mdi:eye'" class="text-2xl"></iconify-icon>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 pt-4" style="border-top: 1px solid #0C3A30;">
                            <h6 class="text-xs mt-2">Invested + Interest</h6>
                        </div>
                    </div>
                </div>

                <!-- Total Invested Card -->
                <div class=" rounded-2xl shadow-xl overflow-hidden border border-emerald-200 min-h-[150px]"
                    style="border-top: 4px solid #8bc905; background-image: url('assets/images/hero/hero-image-1.svg'); background-size: cover; background-position: center;">
                    <div class="p-6  rounded-2xl">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium">Total Invested With Us</p>
                                <template x-if="!initBalances.loaded">
                                    <div class="h-8 w-40 mt-2 bg-gray-200 rounded animate-pulse"></div>
                                </template>
                                <template x-if="initBalances.loaded">
                                    <h3 class="text-2xl font-bold text-[#0C3A30] mt-1">
                                        <template x-if="showBalance">
                                            <span x-text="'$' + initBalances.invested.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                                        </template>
                                        <template x-if="!showBalance">
                                            <span class="text-xl">••••••••</span>
                                        </template>
                                    </h3>
                                </template>
                            </div>
                            <div class="p-3 rounded-xl" style="color: #9EDD05;">
                                <iconify-icon icon="fa-solid:award" class="text-2xl"></iconify-icon>
                            </div>
                        </div>
                        <div class="mt-6 pt-2" style="border-top: 1px solid #0C3A30;">
                            <h6 class="text-xs mt-2">Across all investments</h6>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-gradient-to-br from-primary-800 via-primary-700 to-primary-600  rounded-2xl shadow-xl overflow-hidden min-h-[150px]"
                    style="border-top: 4px solid #8bc905; background-image: url('assets/images/hero/hero-image-1.svg'); background-size: cover; background-position: center;">
                    <div class="p-6">
                        <p class="text-sm font-medium text-gray-500">Quick Actions</p>
                        <div class="flex quick-actions-buttons gap-3 mt-4">
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

            <!-- Activity Section -->
            <div class="flex flex-wrap gap-6 mt-6 justify-center">

                <!-- Market Charts -->
                <div class=" p-4 rounded-2xl shadow-xl border border-gray-200 w-full sm:w-[48%] lg:w-1/3" style="min-height: 520px; overflow:hidden; margin-bottom: 2.5rem;">
                    <h2 class="text-lg font-bold text-[#0C3A30] mb-4">
                        Live Market Charts (Crypto, Forex, Stocks, Metaverse etc...)
                    </h2>
                    <div class="tradingview-widget-container" style="height: 400px;">
                        <div x-data="{ loaded: false }" x-init="setTimeout(() => { loaded = true }, 500)">
                            <template x-if="!loaded">
                                <div class="w-full h-full bg-gray-200 rounded-lg animate-pulse flex items-center justify-center">
                                    <div class="text-gray-500">Loading market data...</div>
                                </div>
                            </template>
                            <template x-if="loaded">
                                <div class="tradingview-widget-container__widget"></div>
                            </template>
                        </div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
                            {
                                "colorTheme": "light",
                                "dateRange": "12M",
                                "showChart": true,
                                "locale": "en",
                                "width": "100%",
                                "height": "85%",
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




            </div>


            <!-- Recent Activity -->
            <div class=" rounded-2xl shadow-xl p-6 border border-gray-100 w-full sm:w-[48%] lg:w-1/3"
                style="background-image: url(assets/images/hero/hero-image-1.svg); background-size: cover; background-position: center;">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-primary-800">Recent Activity</h3>
                    <div class="relative">
                        <button @click="activityFilterOpen = !activityFilterOpen" class="flex items-center gap-1 text-sm text-gray-500 hover:text-primary-800">
                            <iconify-icon icon="mdi:filter-outline" class="text-lg"></iconify-icon>
                            <span>Filter</span>
                        </button>
                        <div x-show="activityFilterOpen" @click.away="activityFilterOpen = false"
                            class="absolute right-0 mt-2 w-48 
                            
                            
                            rounded-md shadow-lg z-10 py-1 border border-gray-200">
                            <a href="#" @click="filterActivities('all')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <iconify-icon icon="mdi:format-list-bulleted" class="text-lg"></iconify-icon>
                                All Activities
                            </a>
                            <a href="#" @click="filterActivities('deposit')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <iconify-icon icon="mdi:cash-plus" class="text-lg text-emerald-500"></iconify-icon>
                                Deposits
                            </a>
                            <a href="#" @click="filterActivities('withdrawal')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <iconify-icon icon="mdi:cash-minus" class="text-lg text-red-500"></iconify-icon>
                                Withdrawals
                            </a>
                            <a href="#" @click="filterActivities('investment')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <iconify-icon icon="mdi:chart-line" class="text-lg text-blue-500"></iconify-icon>
                                Investments
                            </a>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 h-[65vh] min-h-[400px] max-h-[700px] overflow-y-auto w-full pr-2" x-data="{
        activityFilter: 'all',
        filterActivities(type) {
            this.activityFilter = type;
        }
    }">
                    @forelse ($recentActivities as $activity)
                    @php
                    // Determine styling based on activity type
                    $baseColor = match($activity['type']) {
                    'Deposit' => 'emerald',
                    'Withdrawal' => 'red',
                    'Investment Matured' => 'amber',
                    'Investment Active' => 'blue',
                    default => 'gray'
                    };

                    // Status styling
                    $statusBg = match($activity['status']) {
                    'Pending' => 'bg-yellow-100',
                    'Ready to Withdraw' => 'bg-amber-100',
                    'Active' => 'bg-blue-100',
                    'Completed' => 'bg-green-100',
                    default => 'bg-gray-100'
                    };

                    $statusTextColor = match($activity['status']) {
                    'Pending' => 'text-yellow-800',
                    'Ready to Withdraw' => 'text-amber-800',
                    'Active' => 'text-blue-800',
                    'Completed' => 'text-green-800',
                    default => 'text-gray-800'
                    };
                    @endphp

                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors max-w-full activity-item"

                        x-show="activityFilter === 'all' || activityFilter === '{{ strtolower(explode(' ', $activity['type'])[0]) }}'"

                        :class="{
                    'border-l-4 border-emerald-500': '{{ $activity['type'] }}' === 'Deposit',
                    'border-l-4 border-red-500': '{{ $activity['type'] }}' === 'Withdrawal',
                    'border-l-4 border-blue-500': '{{ $activity['type'] }}' === 'Investment Active',
                    'border-l-4 border-amber-500': '{{ $activity['type'] }}' === 'Investment Matured'
                 }">
                        <div class="flex items-center gap-4">
                            <div class="bg-{{ $baseColor }}-100 p-3 rounded-lg">
                                <iconify-icon icon="mdi:{{ $activity['icon'] }}" class="text-{{ $baseColor }}-600 text-xl"></iconify-icon>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 truncate">{{ $activity['type'] }}</p>
                                <p class="text-sm text-gray-500">{{ $activity['date']->format('M d, h:i A') }}</p>
                                @if(in_array($activity['type'], ['Investment Active', 'Investment Matured']))
                                <p class="text-xs text-gray-600 mt-1 truncate">Plan: {{ $activity['plan_name'] }}</p>
                                @else
                                <p class="text-xs text-gray-400 truncate">{{ $activity['reference'] }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right space-y-1 ml-2">
                            @if(in_array($activity['type'], ['Deposit', 'Withdrawal', 'Investment Matured']))
                            <template x-if="showBalance">
                                <p class="font-medium text-{{ $baseColor }}-600 whitespace-nowrap">
                                    {{ $activity['type'] === 'Deposit' ? '+' : '-' }}${{ number_format($activity['amount'], 2) }}
                                </p>
                            </template>
                            <template x-if="!showBalance">
                                <p class="font-medium text-{{ $baseColor }}-600 whitespace-nowrap">
                                    ••••••••
                                </p>
                            </template>
                            @endif

                            <div class="flex flex-col items-end">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusBg }} {{ $statusTextColor }} mb-1">
                                    {{ $activity['status'] }}
                                </span>
                                @if($activity['action_url'] && $activity['action_text'])
                                <a href="{{ $activity['action_url'] }}"
                                    class="text-xs bg-{{ $baseColor }}-500 hover:bg-{{ $baseColor }}-600  px-2 py-1 rounded whitespace-nowrap">
                                    {{ $activity['action_text'] }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <iconify-icon icon="mdi:inbox-remove-outline" class="text-4xl text-gray-300"></iconify-icon>
                        <p class="text-gray-400 text-sm mt-2">No recent activity available</p>
                        <a href="{{ route('user.deposit') }}" class="mt-3 inline-block text-sm text-primary-600 hover:text-primary-800 font-medium">
                            Make your first deposit
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>


            <!-- Motivational Quote -->
            <div x-data="quoteRotator()" x-init="startRotation()"
                class="relative rounded-2xl overflow-hidden shadow-2xl pt-6 min-h-[240px] w-full sm:w-[48%] lg:w-1/3 flex items-center justify-center text-center ">
                <div class="absolute inset-0 bg-[#0C3A30]/80 backdrop-blur-sm"
                    style="background-image: url('https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1350&q=80');"></div>
                <div class="relative z-10 px-4 sm:px-8 w-full">
                    <div x-transition:enter="transition-opacity duration-700"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity duration-500"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <p class=" text-xl sm:text-2xl font-semibold italic leading-relaxed"
                            x-text="quotes[currentIndex].quote"></p>
                        <p class="text-primary-200 text-sm mt-4"
                            x-text="quotes[currentIndex].author"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

<style>
    .quick-actions-buttons {
        flex-direction: row;
    }

    @media (max-width: 1024px) {
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

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @media (min-width: 1024px) {
        .tradingview-widget-container {
            height: 600px;
        }
    }

    @media (max-width: 1023px) {
        .tradingview-widget-container {
            height: 500px;
        }
    }

    @media (max-width: 768px) {
        .tradingview-widget-container {
            height: 400px;
        }
    }

    /* Default: no margin on small screens (mobile) */
    .main-content {
        margin-left: 0;
        transition: margin-left 0.3s ease;
    }

    /* Only on mid-sized screens (like fold phones / tablets) */
    @media (min-width: 1024px) and (max-width: 1199px) {
        .main-content {
            margin-left: 260px;
        }
    }
</style>
</div>
@endsection