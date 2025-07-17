@extends('layout.user')

@section('content')

<!-- Main Container with fixed background -->
<div class="w-full min-h-screen bg-cover bg-center bg-no-repeat"style="background-image: url(assets/images/hero/hero-image-1.svg); " >
    <!-- Optional: dark overlay (enable if needed for contrast) -->
    {{-- <div class="absolute inset-0 bg-black opacity-30 z-0"></div> --}}

    <div class="max-w-7xl mx-auto px-4 md:px-6 py-10 relative z-10">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
            <h5 class="font-semibold text-lg md:text-xl" style="color: #0C3A30;">Investment</h5>
            <ul class="flex items-center gap-[6px]">
                <li class="font-medium">
                    <a href="{{ route('user_dashboard') }}"
                       class="flex items-center gap-2 dark:text-white"
                       onmouseover="this.style.color='#9EDD05';"
                       onmouseout="this.style.color='#0C3A30';">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li class="dark:text-white">-</li>
                <li class="font-medium dark:text-white">Investment</li>
            </ul>
        </div>

        @php
            $statusMap = [
                'withdrawn' => ['bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400', 'Withdrawn'],
                'completed' => ['bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400', 'Completed'],
                'active'    => ['bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400', 'Active'],
            ];
            $activeInvestments = $investments->reject(fn($inv) => $inv->is_fully_withdrawn);
        @endphp

        <!-- Desktop Table -->
        <section class="hidden md:block">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-t-4" style="border-color: #9EDD05;">
                    <thead class="bg-gray-100 dark:bg-gray-700/50 text-xs uppercase text-gray-600 dark:text-gray-300">
                        <tr>
                            @foreach (['Plan', 'Amount', 'ROI', 'Profit', 'Start Date', 'End Date', 'Status', 'Action'] as $head)
                                <th class="px-6 py-3" style="color: #0C3A30;">{{ $head }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($activeInvestments as $investment)
                            @php
                                [$statusClass, $statusText] = $statusMap[$investment->status] ?? $statusMap['active'];
                                $highlightRow = $investment->is_withdrawable ? 'bg-green-50 dark:bg-green-900/10' : '';
                            @endphp
                            <tr class="{{ $highlightRow }} hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">{{ $investment->plan->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">${{ number_format($investment->amount_invested, 2) }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $investment->roi ?? '0' }}%</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">${{ number_format($investment->total_profit, 2) }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($investment->start_date)->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($investment->end_date)->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if ($investment->is_withdrawable && $investment->status !== 'withdrawn')
                                        <form method="POST" action="{{ route('investments.withdraw', $investment->id) }}">
                                            @csrf
                                            <button type="submit" class="font-medium text-xs py-2 px-4 rounded transition" style="background-color: #9EDD05; color:#0C3A30;">
                                                Withdraw from investment
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">Not Due</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No active investments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Mobile Cards -->
        <section class="block md:hidden space-y-4 mt-4">
            @forelse ($activeInvestments as $investment)
                @php [$statusClass, $statusText] = $statusMap[$investment->status] ?? $statusMap['active']; @endphp
                <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-2xl shadow-lg p-4 transition hover:shadow-xl">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-base font-semibold" style="color: #0C3A30;">{{ $investment->plan->name ?? 'N/A' }}</h4>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                    <table class="w-full text-sm border-t border-gray-100 dark:border-gray-700 pt-2">
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr><th class="py-2 pr-2 font-medium text-gray-500 dark:text-gray-400">Amount</th><td class="py-2 text-gray-700 dark:text-gray-300">${{ number_format($investment->amount_invested, 2) }}</td></tr>
                            <tr><th class="py-2 pr-2 font-medium text-gray-500 dark:text-gray-400">ROI</th><td class="py-2 text-gray-700 dark:text-gray-300">{{ $investment->roi ?? '0' }}%</td></tr>
                            <tr><th class="py-2 pr-2 font-medium text-gray-500 dark:text-gray-400">Profit</th><td class="py-2 text-gray-700 dark:text-gray-300">${{ number_format($investment->total_profit, 2) }}</td></tr>
                            <tr><th class="py-2 pr-2 font-medium text-gray-500 dark:text-gray-400">Start Date</th><td class="py-2 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($investment->start_date)->format('M d, Y') }}</td></tr>
                            <tr><th class="py-2 pr-2 font-medium text-gray-500 dark:text-gray-400">End Date</th><td class="py-2 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($investment->end_date)->format('M d, Y') }}</td></tr>
                        </tbody>
                    </table>

                    <div class="pt-3">
                        @if ($investment->is_withdrawable && $investment->status !== 'withdrawn')
                            <form method="POST" action="{{ route('investments.withdraw', $investment->id) }}">
                                @csrf
                                <button type="submit" class="w-full text-sm font-medium px-4 py-2 rounded-md" style="background-color: #9EDD05; color:#0C3A30;">
                                     Withdraw from investment
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-center text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700/20 px-4 py-2 rounded-md">
                                Not yet due for withdrawal
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 dark:text-gray-400">No active investments found.</p>
            @endforelse
        </section>

        <!-- Withdrawn Link -->
        <div class="mt-6 flex justify-end">
            <a href="{{ route('user.withdrawn.investments') }}" class="inline-flex items-center gap-1 text-sm" style="color: #0C3A30;">
                View withdrawn
                <iconify-icon icon="solar:arrow-right-linear"></iconify-icon>
            </a>
        </div>
    </div>
</div>
@endsection
