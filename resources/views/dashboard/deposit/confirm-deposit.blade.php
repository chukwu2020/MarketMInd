@extends('layout.user')

@section('content')

<div class="dashboard-main-body" style="background-image: url(assets/images/hero/hero-image-1.svg);">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h5 class="font-semibold mb-0" style="color: #0C3A30;">Deposit</h5>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{ route('user_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600 "
                    onmouseover="this.style.backgroundColor='transparent'; this.style.color='#9EDD05';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0C3A30';">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="font-medium ">confirm deposit</li>
        </ul>
    </div>

    <div class="gap-6 grid grid-cols-1 2xl:grid-cols-12" style="background-image: url(assets/images/hero/hero-image-1.svg);">

        <div class="col-span-12 2xl:col-span-8">
            <div class="gap-6 grid grid-cols-1 sm:grid-cols-12">

                <div class="col-span-12">
                    <div
                        class="nft-promo-card card border-0 rounded-xl overflow-hidden relative z-1 py-6 3xl:px-[76px] 2xl:px-[56px] xl:px-[40px] lg:px-[28px] px-4">
                        <img src="{{ asset('admin_assets/images/nft/nft-gradient-bg.png') }}" class="absolute start-0 top-0 w-full h-full z-[1]"
                            alt="NFT gradient background">
                        <div
                            class="nft-promo-card__inner flex 3xl:gap-[80px] 2xl:gap-[48px] xl:gap-[32px] lg:gap-6 gap-4 items-center relative z-[1]">
                            <div class="nft-promo-card__thumb w-full">
                                <img src="{{ asset('admin_assets/images/nft/nf-card-img.png') }}" alt="NFT card image" class="h-full object-fit-cover">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-4 text-white">Please Confirm Your Deposit</h6>
                                <p class="text-white text-base">Steps to make a deposit:</p>
                                <ol type="1" class="text-white">
                                    <li>1. Copy any of company's wallet address</li>
                                    <li>2. Pay the exact amount generated into the provided wallet address.</li>
                                    <li>3. After successful payment, screenshot the proof of your payment and attach
                                        it in the space provided for confirmation.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12" style="border-width: 2px; border-style: solid; border-color: #9EDD05; border-radius:8px; padding:4px;">
                    <h6 class="mb-4">Company's Wallet Addresses</h6>
                    <div>
                        <div class="relative overflow-x-auto">
                            <!-- Wallet Address Table -->
                            <table class="table bordered-table sm-table mb-0 border border-[#9EDD05]">
                                <thead class="border border-[#9EDD05]">
                                    <tr>
                                        <th class="border border-[#9EDD05]" scope="col">Name</th>
                                        <th class="border border-[#9EDD05] text-center" scope="col">Wallet Address</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td class="text-center border border-[#9EDD05]">{{ $wallet->crypto_name }}</td>
                                        <td class="text-center">
                                            <div class="flex items-center justify-center gap-2 max-w-xs mx-auto">
                                                <!-- Wallet Address -->
                                                <span
                                                    class="truncate max-w-[150px] px-2 py-1 rounded text-sm bg-gray-100 text-black "
                                                    title="{{ $wallet->wallet_address }}">
                                                    {{ $wallet->wallet_address }}
                                                </span>

                                                <!-- Copy Button with data-text instead of target -->
                                                <button class="copy-btn text-sm px-3 py-1 rounded flex items-center gap-1"
                                                    data-clipboard-text="{{ $wallet->wallet_address }}"
                                                    type="button">
                                                    <i class="ri-file-copy-line"></i> Copy
                                                </button>

                                                <!-- Inline feedback -->
                                                <span class="copy-feedback text-xs text-green-600"></span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-10 xl:col-span-12 2xl:col-span-6 2xl:col-start-4">
                    <div class="card border border-neutral-200">
                        <div class="card-body">
                            <h6 class="text-base text-neutral-600  mb-4">Proof of payment</h6>

                          <form id="depositForm" action="{{ route('deposit.submit') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-5">
        <label for="proof" class="inline-block font-semibold text-neutral-600  text-sm mb-2">
            Screenshot <span class="text-danger-600">*</span>
        </label>
        <input type="file" name="proof" class="form-control rounded-lg" id="proof" placeholder="Proof">
        <span class="text-danger">@error('proof'){{ $message }}@enderror</span>
    </div>

    <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; max-width: 100%;">
        <button
            type="button"
            onclick="window.history.back()"
            style="border: 2px solid #dc2626; background-color: #fff; color: #dc2626; padding: 0.75rem 2rem; font-size: 1rem; border-radius: 0.5rem; width: 100%; max-width: 220px;">
            Cancel
        </button>

        <button
            id="submitBtn"
            type="submit"
            style="border: 2px solid #9EDD05; background-color: #9EDD05; color: #0C3A30; padding: 0.75rem 2rem; font-size: 1rem; border-radius: 0.5rem; width: 100%; max-width: 220px;">
            Submit Deposit
        </button>
    </div>
</form>

<!-- Prevent double submission script -->
<script>
    const form = document.getElementById('depositForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
    });
</script>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<style>
    .copy-btn {
        background-color: #9EDD05;
        color: #0C3A30;
        transition: background-color 0.3s, color 0.3s;
    }

    .copy-btn:hover {
        background-color: #0C3A30;
        color: #9EDD05;
    }
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<script>
    const clipboard = new ClipboardJS('.copy-btn');

    clipboard.on('success', function(e) {
        const feedback = e.trigger.nextElementSibling; // .copy-feedback
        feedback.textContent = 'Copied!';
        setTimeout(() => {
            feedback.textContent = '';
        }, 2000);
    });

    clipboard.on('error', function(e) {
        const feedback = e.trigger.nextElementSibling;
        feedback.textContent = 'Failed to copy';
        setTimeout(() => {
            feedback.textContent = '';
        }, 2000);
    });
</script>


@endsection