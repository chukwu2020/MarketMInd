@extends('layout.user')

@section('content')

<!-- Main Container with fixed background -->
<div class="w-full min-h-screen bg-cover bg-center bg-no-repeat">
    {{-- Optional overlay --}}
    {{-- <div class="absolute inset-0 bg-black opacity-30 z-0"></div> --}}

    <div class="max-w-7xl mx-auto px-4 md:px-6 py-10 relative z-10" style="background-image: url(assets/images/hero/hero-image-1.svg); background-repeat: no-repeat; background-size: cover; background-position:center;">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
            <h5 class="font-semibold text-lg md:text-xl" style="color: #0C3A30;">Investment</h5>
            <ul class="flex items-center gap-[6px]">
                <li class="font-medium">
                    <a href="{{ route('user_dashboard') }}"
                       class="flex items-center gap-2"
                       onmouseover="this.style.color='#9EDD05';"
                       onmouseout="this.style.color='#0C3A30';">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="font-medium">Investment</li>
            </ul>
        </div>

        @php
            $statusMap = [
                'withdrawn' => ['bg-red-100 text-red-800 ', 'Withdrawn'],
                'completed' => ['bg-blue-100 text-blue-800 ', 'Completed'],
                'active' => ['bg-green-100 text-green-800 ', 'Active'],
            ];
            $activeInvestments = $investments->reject(fn($inv) => $inv->is_fully_withdrawn);
        @endphp

        <!-- Desktop Table -->
        <section class="hidden md:block min-h-[60vh] flex flex-col justify-start">
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-sm text-left border-t-4" style="border-color: #9EDD05;">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            @foreach (['Plan', 'Amount', 'ROI', 'Profit', 'Start Date', 'End Date', 'Status', 'Action'] as $head)
                                <th class="px-6 py-3" style="color: #0C3A30;">{{ $head }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($activeInvestments as $investment)
                            @php [$statusClass, $statusText] = $statusMap[$investment->status] ?? $statusMap['active']; @endphp
                            <tr>
                                <td class="px-6 py-4">{{ $investment->plan->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">${{ number_format($investment->amount_invested, 2) }}</td>
                                <td class="px-6 py-4">{{ $investment->roi ?? '0' }}%</td>
                                <td class="px-6 py-4">${{ number_format($investment->total_profit, 2) }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($investment->start_date)->format('M d, Y') }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($investment->end_date)->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td class="px-6 py-4 space-y-2">
                                    @if ($investment->is_withdrawable && $investment->status !== 'withdrawn')
                                        <form method="POST" action="{{ route('investments.withdraw', $investment->id) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 rounded-md text-white bg-green-600 hover:bg-green-700 text-sm font-semibold">
                                                Withdraw
                                            </button>
                                        </form>
                                    @elseif (!$investment->is_withdrawable && $investment->available_profit > 0)
                                        <form method="POST" action="{{ route('investments.takeProfit', $investment->id) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 rounded-md text-black bg-yellow-400 hover:bg-yellow-500 text-sm font-semibold">
                                                Take Profit ($50 max) or wait till due date
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-sm">Not eligible</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="flex justify-center items-center h-[50vh]">
                                        <p class="text-gray-400 text-lg text-center">No active investments found.</p>
                                    </div>
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
                <div class="bg-white border border-gray-300 rounded-2xl shadow-lg p-4 transition hover:shadow-xl">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-base font-semibold" style="color: #0C3A30;">{{ $investment->plan->name ?? 'N/A' }}</h4>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                    <table class="w-full text-sm border-t border-gray-100 pt-2">
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <th class="py-2 pr-2 font-medium text-gray-500">Amount</th>
                                <td class="py-2 text-gray-700">${{ number_format($investment->amount_invested, 2) }}</td>
                            </tr>
                            <tr>
                                <th class="py-2 pr-2 font-medium text-gray-500">ROI</th>
                                <td class="py-2 text-gray-700">{{ $investment->roi ?? '0' }}%</td>
                            </tr>
                            <tr>
                                <th class="py-2 pr-2 font-medium text-gray-500">Profit</th>
                                <td class="py-2 text-gray-700">${{ number_format($investment->total_profit, 2) }}</td>
                            </tr>
                            <tr>
                                <th class="py-2 pr-2 font-medium text-gray-500">Start Date</th>
                                <td class="py-2 text-gray-700">{{ \Carbon\Carbon::parse($investment->start_date)->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th class="py-2 pr-2 font-medium text-gray-500">End Date</th>
                                <td class="py-2 text-gray-700">{{ \Carbon\Carbon::parse($investment->end_date)->format('M d, Y') }}</td>
                            </tr>
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
                        @elseif (!$investment->is_withdrawable && $investment->available_profit > 0)
                            <form method="POST" action="{{ route('investments.takeProfit', $investment->id) }}">
                                @csrf
                                <button type="submit" class="w-full text-sm font-medium px-4 py-2 rounded-md bg-yellow-400 hover:bg-yellow-500 text-black" style="background-color: #9EDD05; color:#0C3A30;">
                                    Take Profit ($50 max ) 
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-center text-gray-500 bg-gray-100 px-4 py-2 rounded-md">
                                Not yet due for withdrawal
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">No active investments found.</p>
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
