@extends('layout.user')

@section('content')

<div class="dashboard-main-body">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6 mt-7">
        <h6 class="font-semibold mb-0 text-lg text-gray-800">Withdrawal List</h6>
        <ul class="flex items-center gap-2 text-sm text-gray-600">
            <li class="font-medium">
                <a href="{{ route('user_dashboard') }}" class="flex items-center gap-1 text-[#8AC304]">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="font-medium">Withdrawal list</li>
        </ul>
    </div>

    <!-- Main Section -->
    <div class="grid grid-cols-1 3xl:grid-cols-12 gap-6 mt-6">
        <div class="2xl:col-span-12 3xl:col-span-8">
            <div class="w-full">
                <div class="card-body p-6 bg-white shadow rounded-lg" style="background-image: url('assets/images/hero/hero-image-1.svg');
            min-height: 100vh;
            background-repeat: no-repeat;
            background-size: cover;" style="border-color: 10px solid #065f46;">
                    <div class="flex items-center justify-between mb-5">
                        <h6 class="font-bold text-lg text-gray-800">Recent Withdrawals</h6>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mt-6">
                        @forelse ($withdrawals as $key => $withdrawal)
                        @php
                        $status = strtolower($withdrawal->status);
                       $badgeClass = match($status) {
    'approved', 'completed' => 'badge-approved',
    'pending' => 'badge-pending',
    'rejected' => 'badge-rejected',
    default => 'badge-default',
};
                        @endphp

                        <div class="bg-white border border-gray-100 rounded-2xl shadow-xl p-5 w-full">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-base font-semibold text-gray-800">#{{ $key + 1 }}</h4>
                                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $badgeClass }}">
                                    {{ ucfirst($withdrawal->status) }}
                                </span>
                            </div>

                            <div class="space-y-2 text-sm text-gray-700">
                                <div class="flex justify-between">
                                    <span class="font-medium">Amount:</span>
                                    <span class="text-red-600 font-semibold">${{ number_format($withdrawal->amount, 2) }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="font-medium">Method:</span>
                                    <span>{{ $withdrawal->payment_method }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="font-medium">Status:</span>
                                    <span class="capitalize">{{ $withdrawal->status }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="font-medium">Date:</span>
                                    <span>{{ $withdrawal->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-10 text-gray-500">
                            <iconify-icon icon="mdi:inbox-remove-outline" class="text-4xl text-gray-300 mb-3"></iconify-icon>
                            <p>No withdrawal history found.</p>
                            <a href="{{ route('user.withdraw.form') }}" class="mt-3 inline-block text-sm text-primary-600 hover:text-primary-800 font-medium">
                                Make your first withdrawal
                            </a>
                        </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inline fallback styles -->
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

    .badge-default {
        background-color: #f3f4f6;
        color: #374151;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    .badge-rejected {
        background-color: #ff6767ff;
        color: #fff ;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-weight: 500;
        font-size: 0.75rem;
    }
</style>

@endsection