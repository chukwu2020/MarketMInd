@extends('layout.user')

@section('content')

<div class="dashboard-main-body" style="background-image: url('assets/images/hero/hero-image-1.svg'); min-height: 100vh; background-repeat: no-repeat; background-size: cover;">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6 mt-7">
        <h6 class="font-semibold mb-0 text-lg text-gray-800">Deposit List</h6>
        <ul class="flex items-center gap-2 text-sm text-gray-600">
            <li class="font-medium">
                <a href="{{ route('user_dashboard') }}" class="flex items-center gap-1 text-[#8AC304]">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="font-medium">Deposit list</li>
        </ul>
    </div>

    <!-- Main Section -->
    <div class="grid grid-cols-1 3xl:grid-cols-12 gap-6 mt-6">
        <div class="2xl:col-span-12 3xl:col-span-8">
            <div class="w-full">
                <div class="card-body p-6 bg-white shadow rounded-lg">
                    <div class="flex items-center justify-between mb-5">
                        <h6 class="font-bold text-lg text-gray-800">Recent Deposits</h6>
                    </div>

                    <!-- Mobile scroll notice -->
                    <div class="flex items-center justify-end text-sm text-gray-500 px-2 pt-2 md:hidden">
                        <span class="flex items-center gap-1 animate-pulse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Scroll right
                        </span>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto bg-white rounded-md mt-4">
                        <table class="min-w-full text-sm text-left table-auto">
                            <thead class="bg-gray-100 text-gray-600 font-semibold">
                                <tr>
                                    <th class="py-3 px-4">#</th>
                                    <th class="py-3 px-4">Plan</th>
                                    <th class="py-3 px-4">Wallet</th>
                                    <th class="py-3 px-4">Amount</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    <th class="py-3 px-4">Date</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse ($deposits as $key => $deposit)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="py-3 px-4">{{ $key + 1 }}</td>
                                        <td class="py-3 px-4">{{ $deposit->plan->name }}</td>
                                        <td class="py-3 px-4">{{ $deposit->wallet->crypto_name }}</td>
                                        <td class="py-3 px-4">${{ number_format($deposit->amount_deposited, 2) }}</td>
                                        <td class="py-3 px-4 text-center">
                                            @if($deposit->status)
                                                <span style="background-color: #d1fae5; color: #065f46;" class="px-3 py-1 rounded text-sm font-medium">Approved</span>
                                            @else
                                                <span style="background-color: #fef3c7; color: #92400e;" class="px-3 py-1 rounded text-sm font-medium">Pending</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-500">{{ $deposit->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-6 text-gray-500">No deposit history found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
