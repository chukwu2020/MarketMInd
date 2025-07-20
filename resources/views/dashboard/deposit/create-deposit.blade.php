@extends('layout.user')

@section('content')
<!-- Include Choices.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

<style>
    /* Choices.js selectable items highlight and selected */
    .choices__item--selectable.is-highlighted,
    .choices__item--selectable.is-selected,
    .choices__list--dropdown .choices__item--selectable.is-highlighted,
    .choices__list--dropdown .choices__item--selectable.is-selected {
        background-color: #8AC304 !important;
        color: #0C3A30 !important;
    }

    /* Select and form control general styling */
    select.form-control,
    .form-control {
        border: none;
        border-top: 4px solid #8AC304;
        border-radius: 0.5rem;
        background-color: white;
        font-weight: 600;
        color: #0C3A30;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    /* Specific styling for amount input */
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

    /* Choices.js inner container styling */
    .choices__inner {
        border: none !important;
        border-top: 4px solid #8AC304 !important;
        border-radius: 0.5rem !important;
        background-color: white !important;
        font-weight: bold;
        color: #0C3A30 !important;
    }

    /* Remove outline and shadow on focus */
    .choices:focus,
    .choices__inner:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    /* Placeholder color */
    .choices__placeholder {
        color: #0C3A30 !important;
        opacity: 0.7;
    }

    /* Card container styling */
    .card {
        border-top: 4px solid #9EDD05;
        box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
        background-color: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
    }

    /* Custom button styling */
    .btn-custom {
        background-color: #9EDD05;
        color: #0C3A30;
        font-weight: 600;
        padding: 0.75rem 2.5rem;
        border-radius: 0.5rem;
        transition: background-color 0.3s ease;
        border: none;
        cursor: pointer;
        user-select: none;
    }

    .btn-custom:hover,
    .btn-custom:focus {
        background-color: #8AC304;
        color: #0C3A30;
        outline: none;
    }
</style>


<div class="dashboard-main-body" style="background-image: url(assets/images/hero/hero-image-1.svg);">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
        <h5 class="font-semibold mb-0  " style="color: #0C3A30;">Deposit</h5>
        <ul class="flex items-center gap-[6px]">
            <li class="font-medium">
                <a href="{{ route('user_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600 " onmouseover="this.style.backgroundColor='transparent'; this.style.color='#9EDD05';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0C3A30';">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="font-medium ">Deposit</li>
        </ul>
    </div>
    <div class="flex items-center justify-end text-sm text-gray-500 px-2 pt-2 md:hidden">
        <span class="flex items-center gap-1 animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            Scroll right
        </span>
    </div>

    <!-- Plans Table -->
    <div class="grid grid-cols-12 mb-8">
        <div class="col-span-12 relative">
            <div class="card rounded-xl p-6 overflow-x-auto">
 <div class="w-full min-w-[600px] sm:min-w-0">
                <table class="table w-full whitespace-nowrap">
                    
                    <thead style="background-image: url(assets/images/hero/hero-image-1.svg);">
                        <tr>
                            <th>#</th>
                            <th>Plan Name</th>
                            <th>($) Minimum Deposit</th>
                            <th>($) Maximum Deposit</th>
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
                            <td>{{ $plan->interest_rate }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
 </div>

            </div>
        </div>
    </div>

    <!-- Deposit Form -->
    <div class="card rounded-lg p-10 max-w-3xl mx-auto" style="background-image: url(assets/images/hero/hero-image-1.svg);">
        <p class="mb-6 text-lg font-semibold text-neutral-900">Choose An Investment Plan to Deposit</p>

        <form action="{{ route('user.make-deposit') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid md:grid-cols-2 gap-6">

                <!-- Select Package -->
                <!-- <div>
                    <label for="plan_id" class="block mb-2 font-semibold text-neutral-900 dark:text-white">
                        Select Package <span class="text-red-600">*</span>
                    </label>
                    <select name="plan_id" id="plan_id" class="form-control">
                        <option selected disabled>Choose Package</option>
                        @foreach($plans as $index => $plan)
                        @php
                        $number = $index + 1;
                        $name = 'Plan (' . ucfirst($plan->name) . ')';
                        $duration = 'Duration: ' . $plan->duration . ' Day' . ($plan->duration > 1 ? 's' : '');
                        $roi = 'ROI: ' . $plan->interest_rate . '%';

                        // Format sections with fixed width using str_pad
                        $col1 = str_pad("$number. $name", 30); // Left
                        $col2 = str_pad($duration, 25, ' ', STR_PAD_BOTH); // Centered
                        $col3 = str_pad($roi, 15, ' ', STR_PAD_LEFT); // Right

                        $optionText = $col1 . $col2 . $col3;
                        @endphp

                        <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $optionText }}
                        </option>
                        @endforeach

                    </select>
                    <span class="text-red-600 text-sm mt-1 block">@error('plan_id'){{ $message }}@enderror</span>
                </div> -->


                <div>
                    <label for="plan_id" class="block mb-2 font-semibold text-neutral-900 ">
                        Select Package <span class="text-red-600">*</span>
                    </label>
                 <select name="plan_id" id="plan_id" class="form-control text-sm sm:text-base">
    <option selected disabled>Choose Package</option>
    @foreach($plans as $plan)
        @php
            $name = ucfirst($plan->name);
            $dayText = $plan->duration == 1 ? 'Day' : 'Days';
            $duration = "{$plan->duration} {$dayText}";
            $roi = $plan->interest_rate . '% ROI';
            $label = "$name | $duration | $roi";
        @endphp
        <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>

                    <span class="text-red-600 text-sm mt-1 block">@error('plan_id'){{ $message }}@enderror</span>
                </div>



                <!-- Select Payment Method -->
                <div>
                    <label for="wallet_id" class="block mb-2 font-semibold text-neutral-900">
                        Select Cryptocurrency <span class="text-red-600">*</span>
                    </label>
                    <select name="wallet_id" id="wallet_id" class="form-control">
                        <option selected disabled>Choose Payment Method</option>
                        @foreach($wallets as $wallet)
                        <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                            {{ ucfirst($wallet->crypto_name) }}
                        </option>
                        @endforeach
                    </select>
                    <span class="text-red-600 text-sm mt-1 block">@error('wallet_id'){{ $message }}@enderror</span>
                </div>

                <!-- Amount Input -->
                <div class="md:col-span-2">
                    <label for="amount" class="block mb-2 font-semibold text-neutral-900">
                        Amount <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="amount" id="amount" value="{{ old('amount') }}"
                        placeholder="Amount" class="form-control rounded-lg w-full px-3 py-2">
                    <span class="text-red-600 text-sm mt-1 block">@error('amount'){{ $message }}@enderror</span>
                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 flex justify-center gap-6 mt-4">
                    <button type="reset"
                        class="px-10 py-3 border-2 border-red-600 text-red-600 rounded-lg hover:bg-red-100 transition"
                        style="border: 2px solid red;" onmouseover="this.style.backgroundColor='red'; this.style.color='black';">
                        Reset
                    </button>
                    <button type="submit" class="btn-custom px-10 py-3 rounded-lg font-semibold">
                        Continue
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Include Choices.js JS -->
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