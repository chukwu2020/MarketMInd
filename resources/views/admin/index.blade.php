@extends('layout.admin')

@section('content')

<div class="dashboard-main-body">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 ">Dashboard</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{ route('admin_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600 ">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="font-medium">AI</li>
        </ul>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-6">
        <!-- Total Users -->
        <div class="card shadow-none border border-gray-200 rounded-lg h-full bg-gradient-to-r from-cyan-600/10 to-white">
            <div class="card-body p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-medium text-neutral-900 mb-1">Total Users</p>
                        <h6 class="mb-0">{{ number_format($totalUsers) }}</h6>
                    </div>
                    <div class="w-[50px] h-[50px] bg-cyan-600 rounded-full flex justify-center items-center">
                        <iconify-icon icon="gridicons:multiple-users" class="text-white text-2xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Deposits -->
        <div class="card shadow-none border border-gray-200 rounded-lg h-full bg-gradient-to-r from-green-600/10 to-white">
            <div class="card-body p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-medium text-neutral-900 mb-1">User Total Available Balance</p>
                        <h6 class="mb-0">${{ number_format($totalDeposits, 2) }}</h6>
                    </div>
                    <div class="w-[50px] h-[50px] bg-green-600 rounded-full flex justify-center items-center">
                        <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
 <div class="card shadow-none border border-gray-200 rounded-lg h-full bg-gradient-to-r from-green-600/10 to-white">
            <div class="card-body p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-medium text-neutral-900 mb-1">User Id Verification</p>
                       <a href="{{route('admin.id.verifications')}}"></a>
                    </div>
                    <div class="w-[50px] h-[50px] bg-green-600 rounded-full flex justify-center items-center">
                        <iconify-icon icon="solar:wallet-bold" class="text-white text-2xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Withdrawals -->
        <div class="card shadow-none border border-gray-200 rounded-lg h-full bg-gradient-to-r from-red-600/10 to-white">
            <div class="card-body p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-medium text-neutral-900 mb-1">Total Withdrawals</p>
                        <h6 class="mb-0">${{ number_format($totalWithdrawals, 2) }}</h6>
                    </div>
                    <div class="w-[50px] h-[50px] bg-red-600 rounded-full flex justify-center items-center">
                        <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-white text-2xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>

      
    </div>
 <!-- Deposits Quick Access -->
<div class="card shadow-none border border-gray-200 rounded-lg h-full bg-gradient-to-r from-yellow-600/10 to-white">
    
    <div class="card-body p-5">
        <div class="flex flex-wrap items-center justify-between border border-red-300 rounded-lg h-full bg-red-100  gap-3">
            <div>
                <p class="font-medium text-neutral-900 mb-1">Deposits</p>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.deposits.pending') }}" class="text-sm text-yellow-700 hover:underline">
                        Pending Deposits
                        @if(isset($pendingDepositsCount) && $pendingDepositsCount > 0)
                            <span class="ml-2 inline-block bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                {{ $pendingDepositsCount }}
                            </span>
                        @endif
                    </a>
                 
                </div>
            </div>
            <div class="w-[50px] h-[50px] bg-yellow-600 rounded-full flex justify-center items-center">
                <iconify-icon icon="hugeicons:bitcoin-circle" class="text-white text-2xl"></iconify-icon>
            </div>
        </div>
    </div>
</div>

<!-- Withdrawals Quick Access -->
<div class="card shadow-none border border-gray-200 rounded-lg h-full bg-gradient-to-r from-blue-600/10 to-white">
    <div class="card-body p-5">
        <div class="flex flex-wrap border border-red-300 rounded-lg h-full bg-red-100  items-center justify-between gap-3">
            <div>
                <p class="font-medium text-neutral-900 mb-1">Withdrawals</p>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('withdrawals.pending') }}" class="text-sm text-yellow-700 hover:underline">
                        Pending Withdrawals
                        @if(isset($pendingWithdrawalsCount) && $pendingWithdrawalsCount > 0)
                            <span class="ml-2 inline-block bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                {{ $pendingWithdrawalsCount }}
                            </span>
                        @endif
                    </a>
                
                </div>
            </div>
            <div class="w-[50px] h-[50px] bg-blue-600 rounded-full flex justify-center items-center">
                <iconify-icon icon="hugeicons:money-send-square" class="text-white text-2xl"></iconify-icon>
            </div>
        </div>
    </div>
</div>
    <!-- Edit User Balance Card -->
    <div class="rounded-xl border border-red-200 bg-gradient-to-r from-red-600/10 to-white shadow-md transition hover:shadow-lg mt-6">
        <div class="p-5">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <p class="font-medium text-neutral-900 mb-1">Edit user balance</p>

                <!-- Strong visible link -->
                <div>
                    <a href="{{ route('user.index') }}"
                       class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-lg font-semibold shadow-md transition">
                        <i class="ri-circle-fill text-white text-xs"></i>
                        Click here
                    </a>
                </div>

                <!-- Icon -->
                <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center shadow-md">
                    <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-white text-2xl"></iconify-icon>
                </div>
            </div>
        </div>
    </div>
   


    <!-- View Messages Card -->
    <div class="rounded-xl border border-red-200 bg-gradient-to-r from-red-600/10 to-white shadow-md transition hover:shadow-lg mt-6">
        <div class="p-5">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <p class="font-medium text-neutral-900 mb-1">View messages</p>

                <!-- Strong visible link -->
                <div>
                    <a href="{{ route('admin.messages.index') }}"
                       class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-lg font-semibold shadow-md transition">
                        <i class="ri-circle-fill text-white text-xs"></i>
                        Click here
                    </a>
                </div>

                

                <!-- Icon -->
                <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center shadow-md">
                    <iconify-icon icon="fa6-solid:file-invoice-dollar" class="text-white text-2xl"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
