@extends('layout.admin')

@section('content')
@foreach(auth()->user()->unreadNotifications as $notification)
    <div class="p-2 bg-gray-100 text-sm mb-2 rounded">
        {{ $notification->data['message'] }}
    </div>
@endforeach

<div class="dashboard-main-body">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 dark:text-white">Dashboard</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{route('admin_dashboard')}}" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li class="dark:text-white">-</li>
            <li class="font-medium dark:text-white">AI</li>
        </ul>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-6">
        <!-- Total Users -->
        <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-cyan-600/10 to-white">
            <div class="card-body p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-medium text-neutral-900 dark:text-white mb-1">Total Users</p>
                        <h6 class="mb-0 dark:text-white">{{ number_format($totalUsers) }}</h6>

                    </div>
                    <div class="w-[50px] h-[50px] bg-cyan-600 rounded-full flex justify-center items-center">
                        <iconify-icon icon="gridicons:multiple-users" class="text-white text-2xl"></iconify-icon>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Total Deposits -->
        <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-green-600/10 to-white">
            <div class="card-body p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-medium text-neutral-900 dark:text-white mb-1">User Total Available Balance</p>
                  <h6 class="mb-0 dark:text-white">${{ number_format($totalDeposits, 2) }}</h6>
                    </div>
                    <div class="w-[50px] h-[50px] bg-green-600 rounded-full flex justify-center items-center">
                        <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl"><iconify-icon>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Total Withdrawals -->
        <div class="card shadow-none border border-gray-200 dark:border-neutral-600 dark:bg-neutral-700 rounded-lg h-full bg-gradient-to-r from-red-600/10 to-white">
            <div class="card-body p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-medium text-neutral-900 dark:text-white mb-1">Total Withdrawals</p>
                     <h6 class="mb-0 dark:text-white">${{ number_format($totalWithdrawals, 2) }}</h6>
                    </div>
                    <div class="w-[50px] h-[50px] bg-red-600 rounded-full flex justify-center items-center">
                        <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-white text-2xl"></iconify-icon>
                    </div>
                </div>
                
            </div>
        </div>



<!-- card -->
       <div class="rounded-xl border border-red-200 dark:border-neutral-600 dark:bg-neutral-700 bg-gradient-to-r from-red-600/10 to-white shadow-md transition hover:shadow-lg">
    <div class="p-5">
        <div class="flex items-center justify-between gap-4 flex-wrap">
             <p class="font-medium text-neutral-900 dark:text-white mb-1">Edit user balance</p>
            <!-- Left Content -->
            <div>
                <a href="{{ route('user.index') }}" class="flex items-center gap-2 text-red-700 dark:text-red-400 hover:text-red-800 font-medium transition">
                    <i class="ri-circle-fill text-red-600"></i>
                    Click here
                </a>
            </div>

            <!-- Icon Circle -->
            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center shadow-md">
                <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-white text-2xl"></iconify-icon>
            </div>
        </div>
    </div>
</div>


<!-- contact us messages -->
   <div class="rounded-xl border border-red-200 dark:border-neutral-600 dark:bg-neutral-700 bg-gradient-to-r from-red-600/10 to-white shadow-md transition hover:shadow-lg">
    <div class="p-5">
        <div class="flex items-center justify-between gap-4 flex-wrap">
             <p class="font-medium text-neutral-900 dark:text-white mb-1">View messages</p>
            <!-- Left Content -->
            <div>
                <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-2 text-red-700 dark:text-red-400 hover:text-red-800 font-medium transition">
                    <i class="ri-circle-fill text-red-600"></i>
                    Click here
                </a>
            </div>

            <!-- Icon Circle -->
            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center shadow-md">
                <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-white text-2xl"></iconify-icon>
            </div>
        </div>
    </div>
</div>

    </div>
</div>

@endsection
