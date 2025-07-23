@extends('layout.user')

@section('content')
<style>
    .custom-btn {
        background-color: #9EDD05;
        color: #0C3A30;
        padding: 0.75rem 1.5rem;
        font-weight: bold;
        text-align: center;
        border-radius: 9999px;
        transition: all 0.3s ease;
        display: inline-block;
        width: 100%;
    }

    .custom-btn:hover {
        background-color: #89C604;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .custom-badge {
        background-color: #9EDD05;
        color: #0C3A30;
        font-weight: bold;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    .check-icon {
        background-color: #9EDD05;
        color: #0C3A30;
        border-radius: 9999px;
        padding: 6px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .plan-heading {
        color: #0C3A30;
    }
</style>

<div class="bg-white  py-20 min-h-screen">
    <div class="container mx-auto   px-4 py-10">
        <!-- Section Header -->

        <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
            <h5 class="font-semibold mb-0  " style="color: #0C3A30; padding-right:0.8rem;">Plans </h5>
            <ul class="flex items-center gap-[6px]">
                <li class="font-medium">
                    <a href="{{ route('user_dashboard') }}" class="flex items-center gap-2 hover:text-primary-600 " onmouseover="this.style.backgroundColor='transparent'; this.style.color='#9EDD05';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0C3A30';">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="font-medium ">Plans</li>
            </ul>
        </div>
        <div class="text-center mb-16">
            <h4 class="text-3xl md:text-5xl font-extrabold mt-3 leading-tight plan-heading">
                OUR PRICING PLANS
            </h4>
        </div>

        <!-- Plan Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($plans as $plan)
            <div class="bg-white  border border-gray-200 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 p-6 flex flex-col justify-between relative group" style="background-image: url(assets/images/hero/hero-image-1.svg);">

                <!-- Popular Badge -->
                @if($loop->first)
                <span class="absolute top-4 right-4 custom-badge">
                    Popular
                </span>
                @endif

                <!-- Icon -->
                <div class="flex justify-center mb-5">

                    <img src=" assets/images/depositimage.jpg' " alt="Plan Icon" style="width: 104px; height:84px; border-radius:6px;">
             

                </div>

                <!-- Plan Name & Interest -->
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-semibold capitalize plan-heading">
                        {{ $plan->name }}
                    </h3>
                    <p class="text-lg mt-1 text-gray-700 ">
                        <span class="font-bold">{{ $plan->interest_rate }}%</span>
                        <span class="text-sm font-normal">/ Per Term</span>
                    </p>
                </div>

                <!-- Features List -->
                <div class="flex justify-center">
                    <ul class="space-y-4 text-sm text-gray-700text-left">
                        <li class="flex items-start gap-3">
                            <span class="check-icon">
                                <i class="ri-check-line"></i>
                            </span>
                            <span><strong>Duration:</strong> {{ $plan->duration }} Days</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="check-icon">
                                <i class="ri-check-line"></i>
                            </span>
                            <span><strong>Percentage:</strong> {{ $plan->interest_rate }}%</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="check-icon">
                                <i class="ri-check-line"></i>
                            </span>
                            <span><strong>Min Deposit:</strong> ${{ number_format($plan->minimum_amount) }}</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="check-icon">
                                <i class="ri-check-line"></i>
                            </span>
                            <span><strong>Max Deposit:</strong> ${{ number_format($plan->maximum_amount) }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Get Started Button -->
                <a href="{{ route('user.deposit') }}" class="custom-btn mt-8">
                    Get Started <i class="ri-arrow-right-up-line ml-1"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection