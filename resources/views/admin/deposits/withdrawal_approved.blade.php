@extends('layout.admin')

@section('content')

<div class="dashboard-main-body p-4 sm:p-6 lg:p-8">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 dark:text-white">Approved Withdraws</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{route('admin_dashboard')}}" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li class="dark:text-white">-</li>
            <li class="font-medium dark:text-white"> withdraws</li>
        </ul>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if($approvedWithdrawals->isEmpty())
        <div class="text-gray-500">No balance withdrawal requests at the moment.</div>
    @else

    <div class="grid grid-cols-1 2xl:grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="card border-0 h-full">
                <div class="card-header">
                    <div class="flex items-center flex-wrap gap-2 justify-between">
                        <h6 class="font-bold text-lg mb-0">Approved Withdrawals</h6>
                    </div>
                </div>
                <div class="card-body p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-[900px] w-full table mb-0 divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Requested At</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($approvedWithdrawals as $withdrawal)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $withdrawal->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $withdrawal->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ₦{{ number_format($withdrawal->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                            {{ $withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($withdrawal->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $withdrawal->created_at->format('d M, Y h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('withdraw.delete', $withdrawal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this withdrawal?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- overflow-x-auto -->
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col-span-12 -->
    </div> <!-- grid -->

    @endif
</div>

@endsection
