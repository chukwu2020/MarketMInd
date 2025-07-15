@extends('layout.admin')
@section('content')

<div class="dashboard-main-body">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h6 class="font-semibold mb-0 dark:text-white">Add Plan</h6>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="index.html" class="flex items-center gap-2 hover:text-primary-600 dark:text-white">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li class="dark:text-white">-</li>
            <li class="font-medium dark:text-white">Add Wallet</li>
        </ul>
    </div>

    <div class="card h-full rounded-xl overflow-hidden border-0">
        <div class="card-body p-10">
            <form action="{{ route('wallet.create') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-2 gap-x-5">
                    <div class="mb-3">
                        <label for="firebaseSecretKey" class="text-sm font-semibold mb-2 block text-neutral-900 dark:text-white">Crypto Name</label>
                        <input type="text" class="form-control rounded-lg" name="crypto_name" placeholder="Crypto name" value="{{ old('crypto_name') }}">
                        <span class="text-danger" style="color: red;">@error ('crypto_name') {{ $message }} @enderror</span>
                    </div>

                    <div class="mb-3">
                        <label for="firebaseSecretKey" class="text-sm font-semibold mb-2 block text-neutral-900 dark:text-white">Wallet Address</label>
                        <input type="text" class="form-control rounded-lg" name="wallet_address" placeholder="Wallet Address" value="{{ old('wallet_address') }}">
                        <span class="text-red" style="color: red;">@error ('wallet_address') {{ $message }} @enderror</span>
                    </div>

                    <div class="flex items-center justify-center gap-3 mt-6 col-span-2">
                        <button type="reset" class="border border-danger-600 hover:bg-danger-200 text-danger-600 text-base px-10 py-[11px] rounded-lg">
                            Reset
                        </button>
                        <button type="submit" class="btn btn-primary border border-primary-600 text-base px-6 py-3 rounded-lg">
                            Save Address
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection