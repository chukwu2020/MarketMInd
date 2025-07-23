@extends('layout.user')

@section('content')

<!-- Choices.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

<style>
    .choices__item--selectable.is-highlighted,
    .choices__item--selectable.is-selected {
        background-color: #8AC304 !important;
        color: #0C3A30 !important;
    }

    select.form-control,
    .form-control {
        border: none;
        border-top: 4px solid #8AC304;
        border-radius: 0.5rem;
        background-color: white;
        font-weight: 600;
        color: #0C3A30;
    }

    input#amount.form-control {
        border: 1.5px solid #9EDD05;
        font-weight: 600;
    }

    input#amount.form-control:hover,
    input#amount.form-control:focus {
        border-color: #9EDD05;
        box-shadow: 0 0 5px rgba(158, 221, 5, 0.6);
        outline: none;
        background-color: white;
        color: #0C3A30;
    }

    .choices__inner {
        border: none !important;
        border-top: 4px solid #8AC304 !important;
        border-radius: 0.5rem !important;
        background-color: white !important;
        font-weight: bold;
        color: #0C3A30 !important;
    }

    .choices__placeholder {
        color: #0C3A30 !important;
        opacity: 0.7;
    }

    .btn-custom {
        background-color: #9EDD05;
        color: #0C3A30;
        font-weight: 600;
        padding: 0.75rem 2.5rem;
        border-radius: 0.5rem;
        transition: background-color 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-custom:hover {
        background-color: #8AC304;
        color: #0C3A30;
    }
</style>

<div class="dashboard-main-body">
    <!-- Breadcrumb -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h5 class="font-semibold mb-0" style="color: #0C3A30;">Deposit</h5>
        <ul class="flex items-center gap-[6px]">
            <li>
                <a href="{{ route('user_dashboard') }}"
                    class="flex items-center gap-2 hover:text-[#9EDD05]"
                    style="color: #0C3A30;">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="font-medium" style="color: #9EDD05;">Deposit</li>
        </ul>
    </div>

    <!-- Plans Table -->
    <div class="grid grid-cols-12 mb-8">
        <div class="col-span-12">
            <div class="card rounded-xl p-6 overflow-x-auto">
                <div class="w-full min-w-[600px] sm:min-w-0">
                    <table class="table w-full whitespace-nowrap text-sm">
                        <thead>
                            <tr class="text-left">
                                <th>#</th>
                                <th>Plan Name</th>
                                <th>Min Deposit ($)</th>
                                <th>Max Deposit ($)</th>
                                <th>Interest Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plans as $index => $plan)
                            <tr class="hover:bg-green-50">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ ucfirst($plan->name) }}</td>
                                <td>{{ number_format($plan->minimum_amount, 2) }}</td>
                                <td>{{ number_format($plan->maximum_amount, 2) }}</td>
                                <td>{{ rtrim(rtrim($plan->interest_rate, '0'), '.') }}%</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Deposit Form -->
    <div class="card p-10 max-w-3xl mx-auto" style="background-image: url(assets/images/hero/hero-image-1.svg);">
        <p class="mb-6 text-lg font-semibold text-neutral-900">Choose An Investment Plan to Deposit</p>

        <form action="{{ route('user.make-deposit') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid md:grid-cols-2 gap-6">

                <!-- Package Select -->
                <div>
                    <label for="plan_id" class="block mb-2 font-bold text-neutral-900">
                        Select Package <span class="text-red-600">*</span>
                    </label>
                    <!-- <select name="plan_id" id="plan_id" class="form-control">
                        <option selected disabled>Choose Package</option>
                        @foreach($plans as $plan)
                            @php
                                $label = ucfirst($plan->name) . " | " . $plan->duration . " " . Str::plural('Day', $plan->duration) . " | " . $plan->interest_rate . "% ROI";
                            @endphp
                            <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select> -->
                    <select name="plan_id" id="plan_id" class="w-full px-4 py-3 border-0 bg-gray-100 rounded-xl focus:ring-2 focus:ring-purple-500 focus:bg-white transition-all shadow-inner">
                        <option value="" disabled selected class="text-gray-500 font-medium">📦 Choose Investment Package</option>

                        @foreach($plans->groupBy('duration') as $duration => $durationPlans)
                        <optgroup label="⏳ {{ $duration }} Day Plan • {{ $durationPlans->count() }} Options"
              class="text-xl font-bold text-white" style="background-color: #9EDD05; padding: 25px 20px; letter-spacing: 0.5px">
                            @foreach($durationPlans as $plan)
                            @php
                            $label = "{$plan->name} → {$plan->interest_rate}% ";
                            @endphp
                            <option value="{{ $plan->id }}"
                                {{ old('plan_id') == $plan->id ? 'selected' : '' }}
                                class="py-2 my-1 border-t border-gray-600">
                                📈 {{ ucfirst($plan->name) }} →
                                <span class="text-green-600">{{ $plan->interest_rate }}%</span> ROI
                            </option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm mt-1 block">@error('plan_id'){{ $message }}@enderror</span>
                </div>

                <!-- Wallet Select -->
                <div>
                    <label for="wallet_id" class="block mb-2 font-bold text-neutral-900">
                        Select Cryptocurrency <span class="text-red-600">*</span>
                    </label>
                    <select name="wallet_id" id="wallet_id" class="form-control">
                        <option selected disabled>Choose Payment Method</option>
                        @foreach($wallets as $wallet)
                        <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                             🔗{{ ucfirst($wallet->crypto_name) }}
                        </option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm mt-1 block">@error('wallet_id'){{ $message }}@enderror</span>
                </div>

                <!-- Amount -->
                <div class="md:col-span-2">
                    <label for="amount" class="block mb-2 font-bold text-neutral-900">
                        Amount <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="amount" id="amount" class="form-control w-full px-3 py-2"
                        value="{{ old('amount') }}" placeholder="Enter amount">
                    <span class="text-red-600 text-sm mt-1 block">@error('amount'){{ $message }}@enderror</span>
                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 flex justify-center gap-6 mt-4">
                    <button type="reset"
                        class="px-10 py-3 border-2 border-red-600 text-red-600 rounded-lg hover:bg-red-100 transition">
                        Reset
                    </button>
                    <button type="submit" class="btn-custom">
                        Continue
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- Choices.js -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Choices('#plan_id', {
            searchEnabled: false,
            itemSelectText: '',
            shouldSort: false
        });

        new Choices('#wallet_id', {
            searchEnabled: false,
            itemSelectText: '',
            shouldSort: false
        });
    });
</script>

@endsection