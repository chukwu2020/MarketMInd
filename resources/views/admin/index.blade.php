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

        @if(auth()->user()->unreadNotifications->count())
            <div class="col-span-full mb-6">
                <div class="bg-white border border-yellow-300 rounded-lg p-4 shadow">
                    <h5 class="font-semibold text-yellow-700 mb-3">📢 New Notifications</h5>

                    @foreach(auth()->user()->unreadNotifications as $notification)
                        @php
                            $type = $notification->data['type'] ?? 'general';
                            $message = $notification->data['message'] ?? '';
                            $color = $type === 'withdrawal' ? 'red' : ($type === 'deposit' ? 'green' : 'gray');
                        @endphp

                        <div class="flex items-center justify-between bg-{{ $color }}-50 border-l-4 border-{{ $color }}-500 text-{{ $color }}-700 px-4 py-3 mb-2 rounded">
                            <p class="text-sm">{{ $message }}</p>
                            <form action="{{ route('admin.markNotificationAsRead', $notification->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs text-{{ $color }}-700 hover:underline">Mark as read</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
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
