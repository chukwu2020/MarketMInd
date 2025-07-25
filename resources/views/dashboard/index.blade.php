@extends('layout.user')

@section('content')
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
                style="width: 2.5rem; height: 2.5rem; color: #8bc905 !important; background-color: #0C3A30; box-shadow: 0 0 15px rgba(139, 201, 5, 0.64);">&times;</button>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Main Dashboard Content -->
    <div class="dashboard-main-body space-y-6">

        <!-- Header with Breadcrumb -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-[#f0fdf4] px-2 py-3 rounded-lg shadow-sm w-full sm:w-auto">
                <div class="relative">
                    @php
                    $profilePic = $user->profile->profile_pic ?? null;

                    $initials = collect(explode(' ', $user->name))
                    ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                    ->take(2)
                    ->join('') ?: 'U';
                    @endphp

                    @if ($profilePic && file_exists(public_path('storage/profile_pics/' . $profilePic)))
                    <img src="{{ asset('storage/profile_pics/' . $profilePic) }}"
                        alt="{{ $user->name }}"
                        class="rounded-full object-cover"
                        style="width: 80px; height: 80px; border: 2px solid #8bc905;" />
                    @else

                    <div
                        class="flex items-center justify-center font-bold text-2xl text-[#0C3A30] select-none"
                        style="background-color: #8bc905; width: 80px; height: 80px; border-radius: 50%;">
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


        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <a href="{{ route('user_dashboard') }}">
                <h6 class="font-semibold mb-0 flex items-center space-x-2 " style="color: #0C3A30;">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    <span>Dashboard</span>
                </h6>
            </a>

            <ul class="flex items-center space-x-2">
                <li class="text-gray-400">-</li>
                <li class="font-medium text-[#9EDD05]">MarketMind</li>
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

@php
$idVerification = auth()->user()->idVerification;
$status = $idVerification ? $idVerification->status : null;
@endphp

<!-- Verification Status Display -->
<div class="mb-6">
    @if($status === 'approved')
        <!-- APPROVED STATE - GREEN BORDER AND BACKGROUND -->
        <div style="border-left: 4px solid #10B981 !important; background-color: #ECFDF5 !important;" class="p-4 rounded-r-lg relative">
            <div class="flex items-start">
                <svg class="h-5 w-5 flex-shrink-0 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="#10B981">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="font-semibold" style="color: #065F46 !important;">Identity Verified</h4>
                    <p class="text-sm mt-1" style="color: #065F46 !important;">Your identity has been successfully verified.</p>
                </div>
            </div>
            <!-- CLOSE BUTTON (ONLY FOR APPROVED STATE) -->
            <button onclick="this.parentElement.style.display='none'" class="absolute top-2 right-2 text-green-700 hover:text-green-900">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    
    @elseif($status === 'pending')
        <!-- PENDING STATE - YELLOW BACKGROUND AND RED BORDER -->
        <div style="border-left: 4px solid #EF4444 !important; background-color: #FEF3C7 !important;" class="p-4 rounded-r-lg">
            <div class="flex items-start">
                <svg class="h-5 w-5 flex-shrink-0 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="#D97706">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="font-semibold" style="color: #92400E !important;">Verification Pending</h4>
                    <p class="text-sm mt-1" style="color: #92400E !important;">Your documents are under review. Please wait for admin approval.</p>
                </div>
            </div>
        </div>
    
    @elseif($status === 'rejected')
        <!-- REJECTED STATE - RED BORDER AND BACKGROUND -->
        <div style="border-left: 4px solid #DC2626 !important; background-color: #FEE2E2 !important;" class="p-4 rounded-r-lg">
            <div class="flex items-start">
                <svg class="h-5 w-5 flex-shrink-0 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="#DC2626">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="font-semibold" style="color: #991B1B !important;">Verification Rejected</h4>
                    <p class="text-sm mt-1" style="color: #991B1B !important;">Please check your email for details and resubmit your documents.</p>
                    <a href="{{ route('id.form') }}" class="inline-block mt-2 text-sm font-medium" style="color: #B91C1C !important;">
                        Resubmit Documents →
                    </a>
                </div>
            </div>
        </div>
    
    @else
        <!-- NOT SUBMITTED STATE - SHOW VERIFICATION ALERT -->
        @if(session('hide_id_alert') !== true)
        <div style="border-left: 4px solid #EF4444 !important; background-color: #FEE2E2 !important;" class="p-4 rounded-r-lg">
            <div class="flex items-start justify-between">
                <div class="flex items-start">
                    <svg class="h-5 w-5 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" style="color: #DC2626 !important;">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold" style="color: #991B1B !important;">Identity Verification Required</h4>
                        <p class="text-sm mt-1" style="color: #991B1B !important;">Please verify your identity to access all features.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 pl-4">
                    <a href="{{ route('id.form') }}" class="text-white px-3 py-1 rounded-md text-sm font-medium" style="background-color: #EF4444 !important;">
                        Verify Now
                    </a>
                    <form method="POST" action="{{ route('id.alert.dismiss') }}">
                        @csrf
                        <button type="submit" class="p-1 rounded-full hover:bg-red-200" style="color: #DC2626 !important;">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>


            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Available Balance Card -->
                <div class=" rounded-2xl shadow-xl overflow-hidden min-h-[150px]"
                    style="border-top: 4px solid #8bc905; background-image: url('assets/images/hero/hero-image-1.svg'); background-size: cover; background-position: center;">
                    <div class="p-6  rounded-2xl">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="mainColor text-sm font-medium text-[#0C3A30]">Available Balance</p>
                                <template x-if="!initBalances.loaded">
                                    <div class="h-8 w-40 mt-2 bg-gray-200 rounded animate-pulse"></div>
                                </template>
                                <template x-if="initBalances.loaded">
                                    <h3 class="text-2xl font-bold text-primary-800 mt-1">
                                        <template x-if="showBalance">
                                            <span class="text-[#0C3A30]" x-text="'$' + initBalances.available.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                                        </template>
                                        <template x-if="!showBalance">
                                            <span class="text-xl text-[#0C3A30]">••••••••</span>
                                        </template>
                                    </h3>
                                </template>
                            </div>

                            <!-- i will comment it out  -->

                            <div class="p-3 rounded-xl">
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


                <!-- Premium Investment Performance Card -->

                <!-- Premium Investment Performance Card -->
                <div class="investment-performance-card bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden w-full max-w-md mx-auto"
                    style="border-top: 4px solid #8bc905; background-image: url('assets/images/hero/hero-image-1.svg'); background-size: cover; background-position: center;">
                    <div class="p-5">
                        <!-- Header with gradient background -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">INVESTMENT PERFORMANCE</h3>
                                <h6 class="text-xs text-gray-500 mt-1">Live Updates • {{ now()->format('M j, g:i a') }}</h6>
                            </div>
                        </div>

                        <!-- Investment Items -->
                        <div id="investmentContainer" class="space-y-3">
                            @php
                            $allInvestments = auth()->user()->investments()
                            ->where('status','active')
                            ->with('plan')
                            ->orderBy('created_at', 'desc')
                            ->get();
                            $totalEarnedAll = 0;
                            $totalProjectedAll = 0;
                            $displayCount = min(2, count($allInvestments));

                            // Get or create daily earnings cache
                            $dailyEarnings = Cache::remember('user_'.auth()->id().'_daily_earnings', now()->addDay(), function() {
                            return [];
                            });
                            @endphp

                            @foreach($allInvestments->take($displayCount) as $investment)
                            @php
                            // Calculate values
                            $startDate = $investment->created_at;
                            $minutesPassed = now()->diffInMinutes($startDate);
                            $hoursPassed = now()->diffInHours($startDate);
                            $daysPassed = now()->startOfDay()->diffInDays($startDate->startOfDay());
                            $weeksPassed = floor($daysPassed/7);
                            $daysCompleted = min($daysPassed, $investment->plan->duration);

                            // Base calculations
                            $projectedTotal = ($investment->amount_invested * $investment->plan->interest_rate) / 100;
                            $totalProjectedAll += $projectedTotal;
                            $baseDailyRate = $investment->plan->interest_rate / $investment->plan->duration;
                            $baseHourlyRate = $baseDailyRate / 24;
                            $baseMinuteRate = $baseHourlyRate / 60;

                            // Determine plan type
                            $isShortTerm = $investment->plan->duration <= 14;
                                $isLongTerm=$investment->plan->duration >= 28;
                                $isWeekly = $investment->plan->duration % 7 === 0;

                                // Get previous earnings
                                $previousEarned = $dailyEarnings[$investment->id] ?? 0;

                                // Generate random fluctuation (-100 to +100)
                                $fluctuation = mt_rand(-100, 100);
                                $isPositive = $fluctuation >= 0;
                                $fluctuationDisplay = abs($fluctuation);

                                // IMPROVED DAY 0 EARNINGS CALCULATION
                                if ($daysPassed == 0) {
                                // For Day 0 - show small fixed amount between $1-$20
                                $firstDayAmount = min(max($investment->amount_invested * 0.0005, 1), 20);
                                $earnedNow = $previousEarned + $firstDayAmount;
                                }
                                // First day but not Day 0 (hours passed)
                                elseif ($daysPassed == 1 && $hoursPassed < 24) {
                                    // Scale up earnings gradually through first day
                                    $firstDayAmount=min(max($investment->amount_invested * 0.001 * ($hoursPassed/24), 1), 50);
                                    $earnedNow = $previousEarned + $firstDayAmount;
                                    }
                                    // Weekly growth for long-term plans (28+ days) on 7th day
                                    elseif ($isLongTerm && $daysPassed % 7 === 0) {
                                    $earnedNow = $previousEarned + ($projectedTotal * ($baseDailyRate * 7) * (1 + ($fluctuation/100)));
                                    }
                                    // Weekly growth for 7-day plans
                                    elseif ($isWeekly && $daysPassed % 7 === 0) {
                                    $earnedNow = $previousEarned + ($projectedTotal * ($baseDailyRate * 7) * (1 + ($fluctuation/100)));
                                    }
                                    // Daily growth for other plans
                                    else {
                                    $earnedNow = $previousEarned + ($projectedTotal * $baseDailyRate * (1 + ($fluctuation/100)));
                                    }

                                    // Ensure earnings don't exceed 95% before maturity
                                    $totalEarned = min(
                                    $earnedNow,
                                    $projectedTotal * min(0.95, $daysCompleted/$investment->plan->duration)
                                    );

                                    // On maturity day, show exact amount
                                    if ($daysPassed >= $investment->plan->duration) {
                                    $totalEarned = $projectedTotal;
                                    $fluctuation = 0;
                                    $isPositive = true;
                                    }

                                    // Update cache
                                    $dailyEarnings[$investment->id] = $totalEarned;
                                    $totalEarnedAll += $totalEarned;

                                    // Styling based on fluctuation
                                    $trendColor = $isPositive ? 'text-green-600' : 'text-red-600';
                                    $trendBg = $isPositive ? 'bg-green-50' : 'bg-red-50';
                                    $trendBorder = $isPositive ? 'border-green-100' : 'border-red-100';

                                    // Display text based on plan type
                                    if ($daysPassed > $investment->plan->duration) {
                                    $statusText = "Matured ({$investment->plan->duration} days)";
                                    }
                                    elseif ($isLongTerm) {
                                    $statusText = "Week {$weeksPassed} of " . ceil($investment->plan->duration/7);
                                    }
                                    elseif ($isWeekly) {
                                    $statusText = "Week {$weeksPassed} of " . ($investment->plan->duration/7);
                                    }
                                    else {
                                    $statusText = "Day {$daysPassed} of {$investment->plan->duration}";
                                    }
                                    @endphp

                                    <div class="investment-item {{ $trendBg }} rounded-lg p-3 border {{ $trendBorder }} shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm font-medium text-gray-800">{{ strtoupper($investment->plan->name) }}</span>
                                            <span class="text-xs font-bold {{ $trendColor }} flex items-center animate-fluctuation-{{ $isPositive ? 'up' : 'down' }}">
                                                @if($isPositive)
                                                <svg class="w-3 h-3 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M12 7a1 1 0 01-1 1H9v1h2a1 1 0 110 2H9v1h2a1 1 0 110 2H9v1a1 1 0 11-2 0v-1H5a1 1 0 110-2h2v-1H5a1 1 0 110-2h2V8H5a1 1 0 010-2h2V5a1 1 0 112 0v1h2a1 1 0 011 1z" clip-rule="evenodd" />
                                                </svg>
                                                @else
                                                <svg class="w-3 h-3 mr-1 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                @endif
                                                {{ $fluctuationDisplay }}%
                                            </span>
                                        </div>

                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-500">
                                                {{ $statusText }}
                                            </span>
                                            <span class="text-xs font-medium">
                                                <span class="{{ $totalEarned > 0 ? 'text-gray-800' : 'text-gray-500' }}">
                                                    ${{ number_format($totalEarned, 2) }}
                                                </span>
                                                <span class="mx-1 text-gray-300">/</span>
                                                <span class="text-gray-700">${{ number_format($projectedTotal, 2) }}</span>
                                            </span>
                                        </div>

                                        <!-- Progress Bar -->
                                        <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                                            <div class="h-1.5 rounded-full {{ $daysPassed > $investment->plan->duration ? 'bg-purple-500' : ($isPositive ? 'bg-green-500' : 'bg-red-500') }}"
                                                style="width: {{ min(100, ($daysPassed/$investment->plan->duration)*100) }}%"></div>
                                        </div>
                                    </div>
                                    @endforeach
                        </div>

                        <!-- Expanded Investments (Hidden Initially) -->
                        <div id="expandedInvestments" class="hidden space-y-3">
                            @foreach($allInvestments->skip(2) as $investment)
                            <!-- Same investment item structure as above -->
                            @endforeach
                        </div>

                        <!-- Save earnings to cache -->
                        @php
                        Cache::put('user_'.auth()->id().'_daily_earnings', $dailyEarnings, now()->addDay());
                        @endphp

                        <!-- Summary Section -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-600">Total Earned</span>
                                <span class="text-sm font-bold text-gray-800">${{ number_format($totalEarnedAll, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Projected Total</span>
                                <span class="text-xl font-bold text-green-600">${{ number_format($totalProjectedAll, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    @keyframes fluctuationUp {

                        0%,
                        100% {
                            transform: translateY(0);
                        }

                        50% {
                            transform: translateY(-2px);
                        }
                    }

                    @keyframes fluctuationDown {

                        0%,
                        100% {
                            transform: translateY(0);
                        }

                        50% {
                            transform: translateY(2px);
                        }
                    }

                    .animate-fluctuation-up {
                        animation: fluctuationUp 1.5s ease-in-out infinite;
                    }

                    .animate-fluctuation-down {
                        animation: fluctuationDown 1.5s ease-in-out infinite;
                    }

                    .investment-performance-card {
                        border-top-width: 4px;
                        border-top-color: #8bc905;
                    }

                    .total-invested-card {
                        border-top-width: 4px;
                        border-top-color: #8bc905;
                    }

                    #expandedInvestments {
                        max-height: 0;
                        overflow: hidden;
                        transition: max-height 0.5s ease;
                    }

                    #expandedInvestments.show {
                        max-height: 1000px;
                    }

                    .investment-item {
                        transition: all 0.2s ease;
                    }

                    .investment-item:hover {
                        transform: translateY(-1px);
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                    }
                </style>

                <script>
                    // Toggle expanded view
                    function toggleExpand() {
                        const container = document.getElementById('expandedInvestments');
                        container.classList.toggle('show');

                        const btn = document.querySelector('[onclick="toggleExpand()"]');
                        if (container.classList.contains('show')) {
                            btn.textContent = 'Show Less';
                        } else {
                            btn.textContent = `View All ({{ count($allInvestments) }})`;
                        }
                    }

                    // Auto-refresh every 15 seconds
                    document.addEventListener('DOMContentLoaded', function() {
                        const refreshInvestments = () => {
                            fetch(window.location.href + '?refresh=' + new Date().getTime(), {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    cache: 'no-store'
                                })
                                .then(response => response.text())
                                .then(html => {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');
                                    const newComponent = doc.querySelector('.investment-performance-card');
                                    if (newComponent) {
                                        document.querySelector('.investment-performance-card').outerHTML = newComponent.outerHTML;
                                    }
                                });
                        };

                        setInterval(refreshInvestments, 1200);

                        document.addEventListener('visibilitychange', () => {
                            if (!document.hidden) refreshInvestments();
                        });
                    });
                </script>


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

            <div class="rounded-2xl shadow-xl p-6 border border-gray-600 w-full sm:w-[48%] lg:w-1/3" style=" background-image: url('assets/images/hero/hero-image-1.svg');">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-primary-800">Recent Activity</h3>
                    <div class="relative" x-data="{ activityFilterOpen: false }">
                        <button @click="activityFilterOpen = !activityFilterOpen"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white border border-gray-200 shadow-xs hover:bg-primary-50 hover:border-primary-300 hover:text-primary-800 transition-all duration-200">
                            <iconify-icon icon="mdi:filter-outline" class="text-lg text-primary-600"></iconify-icon>
                            <span class="text-sm font-medium">Filter</span>
                        </button>
                        <div x-show="activityFilterOpen" @click.away="activityFilterOpen = false"
                            class="absolute right-0 mt-2 w-48 rounded-md  shadow-lg z-50 py-1 border border-gray-200" style="background-color: white !important;">
                            <a href="#" @click.prevent="$dispatch('filter-activities', 'all')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <iconify-icon icon="mdi:format-list-bulleted" class="text-lg"></iconify-icon>
                                All Activities
                            </a>
                            <a href="#" @click.prevent="$dispatch('filter-activities', 'deposit')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <iconify-icon icon="mdi:cash-plus" class="text-lg text-emerald-500"></iconify-icon>
                                Deposits
                            </a>
                            <a href="#" @click.prevent="$dispatch('filter-activities', 'withdrawal')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <iconify-icon icon="mdi:cash-minus" class="text-lg text-red-500"></iconify-icon>
                                Withdrawals
                            </a>
                            <a href="#" @click.prevent="$dispatch('filter-activities', 'investment')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                <iconify-icon icon="mdi:chart-line" class="text-lg text-blue-500"></iconify-icon>
                                Investments
                            </a>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 h-[65vh] min-h-[400px] max-h-[700px] overflow-y-auto w-full pr-2"
                    x-data="{
            activityFilter: 'all',
            init() {
                window.addEventListener('filter-activities', event => {
                    this.activityFilter = event.detail;
                });
            },
            filterType(type) {
                if (this.activityFilter === 'all') return true;
                return type.toLowerCase() === this.activityFilter;
            }
         }">
                    @forelse ($recentActivities as $activity)
                    @php
                    $typeKey = strtolower(explode(' ', $activity['type'])[0]);

                    $status = strtolower($activity['status']);
                    $badgeClass = match($status) {
                    'pending' => 'badge-pending',
                    'ready to withdraw' => 'badge-warning',
                    'active' => 'badge-active',
                    'completed' => 'badge-approved',
                    default => 'badge-default'
                    };

                    $amountClass = match($activity['type']) {
                    'Deposit' => 'text-emerald-600',
                    'Withdrawal' => 'text-red-600',
                    'Investment Matured' => 'text-amber-600',
                    'Investment Active' => 'text-blue-600',
                    default => 'text-gray-600'
                    };

                    $borderClass = match($activity['type']) {
                    'Deposit' => 'border-emerald-500',
                    'Withdrawal' => 'border-red-500',
                    'Investment Matured' => 'border-amber-500',
                    'Investment Active' => 'border-blue-500',
                    default => 'border-gray-300'
                    };
                    @endphp

                    <template x-if="filterType('{{ $typeKey }}')">
                        <div class="bg-white border {{ $borderClass }} border-l-4 rounded-2xl shadow-xl p-5 w-full hover:bg-gray-50 transition-colors max-w-full flex justify-between items-center gap-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 rounded-lg 
                            @if($typeKey === 'deposit') bg-emerald-100
                            @elseif($typeKey === 'withdrawal') bg-red-100
                            @elseif($typeKey === 'investment') bg-blue-100
                            @elseif($typeKey === 'investment') bg-amber-100
                            @else bg-gray-100 @endif
                        ">
                                    <iconify-icon icon="mdi:{{ $activity['icon'] }}"
                                        class="@if($typeKey === 'deposit') text-emerald-600
                                @elseif($typeKey === 'withdrawal') text-red-600
                                @elseif($typeKey === 'investment') text-blue-600
                                @elseif($typeKey === 'investment') text-amber-600
                                @else text-gray-600 @endif
                            text-xl"></iconify-icon>
                                </div>

                                <div class="flex flex-col min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $activity['type'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $activity['date']->format('M d, h:i A') }}</p>

                                    @if(in_array($activity['type'], ['Investment Active', 'Investment Matured']))
                                    <p class="text-xs text-gray-600 mt-1 truncate">Plan: {{ $activity['plan_name'] }}</p>
                                    @else
                                    <p class="text-xs text-gray-400 truncate">{{ $activity['reference'] }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="text-right space-y-1 ml-2 min-w-[100px]">
                                @if(in_array($activity['type'], ['Deposit', 'Withdrawal', 'Investment Matured']))
                                <p class="{{ $amountClass }} font-semibold whitespace-nowrap">
                                    {{ $activity['type'] === 'Deposit' ? '+' : '-' }}${{ number_format($activity['amount'], 2) }}
                                </p>
                                @endif

                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badgeClass }} mb-1">
                                    {{ ucfirst($activity['status']) }}
                                </span>

                                @if($activity['action_url'] && $activity['action_text'])
                                <a href="{{ $activity['action_url'] }}" class="inline-block text-xs bg-gray-800 hover:bg-gray-900 text-white px-3 py-1 rounded whitespace-nowrap">
                                    {{ $activity['action_text'] }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </template>
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

            <style>
                .badge-approved {
                    background-color: #d1fae5;
                    /* Tailwind's bg-green-100 */
                    color: #065f46;
                    /* Tailwind's text-green-800 */
                    padding: 0.25rem 0.5rem;
                    border-radius: 9999px;
                    font-weight: 500;
                    font-size: 0.75rem;
                }

                .badge-pending {
                    background-color: #fef3c7;
                    /* Tailwind's bg-yellow-100 */
                    color: #92400e;
                    /* Tailwind's text-yellow-800 */
                    padding: 0.25rem 0.5rem;
                    border-radius: 9999px;
                    font-weight: 500;
                    font-size: 0.75rem;
                }

                .badge-warning {
                    background-color: #fde68a;
                    /* Tailwind's bg-yellow-300 */
                    color: #92400e;
                    padding: 0.25rem 0.5rem;
                    border-radius: 9999px;
                    font-weight: 500;
                    font-size: 0.75rem;
                }

                .badge-active {
                    background-color: #dbeafe;
                    /* Tailwind's bg-blue-100 */
                    color: #1d4ed8;
                    /* Tailwind's text-blue-700 */
                    padding: 0.25rem 0.5rem;
                    border-radius: 9999px;
                    font-weight: 500;
                    font-size: 0.75rem;
                }

                .badge-default {
                    background-color: #f3f4f6;
                    color: #374151;
                    padding: 0.25rem 0.5rem;
                    border-radius: 9999px;
                    font-weight: 500;
                    font-size: 0.75rem;
                }
            </style>


            <!-- Motivational Quote -->
            <!-- Motivational Quote -->
            <div x-data="quoteRotator()" x-init="startRotation()"
                class="relative rounded-2xl overflow-hidden shadow-2xl pt-8 min-h-[240px] w-full sm:w-[48%] lg:w-1/3 flex items-center justify-center text-center">

                <div class="absolute inset-0 bg-[#0C3A30]/80 backdrop-blur-sm"
                    style="background-image: url('https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1350&q=80');">
                </div>

                <div class="relative z-10 px-4 sm:px-8 w-full text-white" style="color: white !important;">
                    <div x-transition:enter="transition-opacity duration-700"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity duration-500"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">

                        <p class="text-xl sm:text-2xl font-semibold italic leading-relaxed"
                            style="color: white !important;"
                            x-text="quotes[currentIndex].quote">
                        </p>

                        <p class="text-sm mt-4"
                            style="color: white !important;"
                            x-text="quotes[currentIndex].author">
                        </p>

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