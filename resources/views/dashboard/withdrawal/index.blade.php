@extends('layout.user')

@section('content')
<div class="dashboard-main-body" style="background-image: url('/assets/images/hero/hero-image-1.svg'); height:100%;">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 dark:text-white">Withdrawal List</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{ route('user_dashboard') }}"
                   class="flex items-center gap-2 hover:text-primary-600 dark:text-white"
                   onmouseover="this.style.backgroundColor='transparent'; this.style.color='#8AC304';">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li class="dark:text-white">-</li>
            <li class="font-medium dark:text-white"> list</li>
        </ul>
    </div>

    <div class="grid grid-cols-1 3xl:grid-cols-12 gap-6 mt-6">
        <div class="2xl:col-span-12 3xl:col-span-8">
            <div class="max-w-full">
                <div class="col-span-12">
                    <div class="max-w-full">
                        <div class="card-body p-6 bg-white/80 backdrop-blur-sm rounded-xl shadow">
                            <div class="flex items-center flex-wrap gap-2 justify-between mb-5">
                                <h6 class="font-bold text-lg mb-0">Recent Withdrawals</h6>
                            </div>
                            <div class="table-responsive max-w-full scroll-sm"
                                 style="background-image: url('/assets/images/hero/hero-image-1.svg'); background-size: contain; background-position: center;">
                                <table class="table bordered-table mb-0 xsm-table w-full text-left text-sm">
                                    <thead>
                                        <tr>
                                            <th class="col">#</th>
                                            <th class="col">Amount ($)</th>
                                            <th class="col text-center">Status</th>
                                            <th class="col">Payment Method</th>
                                            
                                            <th class="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($withdrawals as $key => $withdrawal)
                                        <tr class="hover:bg-[#e6f1e9] transition">
                                            <td>{{ $key + 1 }}</td>
                                            <td class="font-semibold">${{ number_format($withdrawal->amount, 2) }}</td>
                                             <td class="text-center">
                                                @if($withdrawal->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-700 px-4 py-1.5 rounded font-medium text-sm">Pending</span>
                                                @else
                                                <span class="bg-green-100 text-green-700 px-4 py-1.5 rounded font-medium text-sm">Approved</span>
                                                @endif
                                            </td>
                                            <td class="capitalize">{{ $withdrawal->payment_method }}</td>
                                           
                                            <td>
                                                <span class="text-secondary-light text-sm">{{ $withdrawal->created_at->format('d M Y, H:i') }}</span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-gray-500 p-4">No withdrawal history found.</td>
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
     </div>
</div>
@endsection
