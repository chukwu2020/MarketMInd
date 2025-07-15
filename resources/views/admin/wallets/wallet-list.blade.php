@extends('layout.admin')
@section('content')

<div class="dashboard-main-body">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 dark:text-white">Wallet List</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{ route('admin_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li class="dark:text-white">-</li>
            <li class="font-medium dark:text-white">Wallet List</li>
        </ul>
    </div>

    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card h-full p-0 rounded-xl border-0 overflow-hidden">
                <div class="card-header border-b border-neutral-200 dark:border-neutral-600 bg-white dark:bg-neutral-700 py-4 px-6 flex items-center justify-between">
                    <h6 class="text-base font-medium text-secondary-light mb-0">All Wallets</h6>
                    <a href="{{ route('create_wallet') }}" class="btn btn-primary text-sm btn-sm px-3 py-3 rounded-lg flex items-center gap-2">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl"></iconify-icon>
                        Add New Wallet
                    </a>
                </div>

                <div class="card-body p-6">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Crypto Name</th>
                                    <th scope="col">Wallet Address</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wallets as $wallet)
                                <tr>
                                    <td>{{ ucfirst($wallet->crypto_name) }}</td>
                                    <td>{{ $wallet->wallet_address }}</td>
                                    <td class="text-center">
                                        <div class="flex items-center gap-3 justify-center">
                                            <button type="button" class="bg-info-100 dark:bg-info-600/25 hover:bg-info-200 text-info-600 dark:text-info-400 font-medium w-10 h-10 flex justify-center items-center rounded-full">
                                                <iconify-icon icon="majesticons:eye-line" class="icon text-xl"></iconify-icon>
                                            </button>

                                            <form action="{{ route('wallet.delete', $wallet->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this wallet?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-danger-100 dark:bg-danger-600/25 hover:bg-danger-200 text-danger-600 dark:text-danger-500 font-medium w-10 h-10 flex justify-center items-center rounded-full">
                                                    <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-between flex-wrap gap-2 mt-6">
                        {{ $wallets->links() }} <!-- Laravel pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection