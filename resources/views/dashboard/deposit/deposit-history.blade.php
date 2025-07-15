@extends('layout.user')
@section('content')

<div class="dashboard-main-body"style="background-image: url(assets/images/hero/hero-image-1.svg); height:100%;">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6 mt-7" >
        <h6 class="font-semibold mb-0 dark:text-white">Deposit List</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{ route('user_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600 dark:text-white" onmouseover="this.style.backgroundColor='tranparent'; this.style.color=' #8AC304';">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li class="dark:text-white">-</li>
            <li class="font-medium dark:text-white">Deposit list</li>
        </ul>
    </div>


    <div class="grid grid-cols-1 3xl:grid-cols-12 gap-6 mt-6">

        <!-- Crypto Home Widgets Start -->
        <div class="2xl:col-span-12 3xl:col-span-8">
            <div class="max-w-full ">

                <div class="col-span-12">
                    <div class="max-w-full">
                        <div class="card-body p-6">
                            <div class="flex items-center flex-wrap gap-2 justify-between mb-5">
                                <h6 class="font-bold text-lg mb-0">Recent Deposit</h6>
                            </div>
                            <div class="flex items-center justify-end text-sm text-gray-500 px-2 pt-2 md:hidden">
    <span class="flex items-center gap-1 animate-pulse">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        Scroll right
    </span>
</div>
                            <div class="table-responsive max-w-full scroll-sm" style="background-image: url(assets/images/hero/hero-image-1.svg);">
                                <table class="table bordered-table mb-0 xsm-table">
                                    <thead>
                                        <tr>
                                            <th class="col">#</th>
                                            <th class="col">Plan</th>
                                            <th class="col">Wallet</th>
                                            <th class="col">Amount</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($deposits as $key => $deposit)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $deposit->plan->name }}</td>
                                            <td>{{ $deposit->wallet->crypto_name }}</td>
                                            <td class="">${{ number_format($deposit->amount_deposited, 2) }}</td>
                                            <td class="text-center">
                                                @if($deposit->status)
                                                <span class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-4 py-1.5 rounded font-medium text-sm">Approved</span>
                                                @else
                                                <span class="bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400 px-4 py-1.5 rounded font-medium text-sm">Pending</span>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="text-secondary-light text-sm"> {{ $deposit->created_at->format('d M Y') }}</span>
                                            </td>


                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-gray-500 p-4">No deposit history found.</td>
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
        <!-- Crypto Home Widgets End -->
    </div>
</div>

@endsection