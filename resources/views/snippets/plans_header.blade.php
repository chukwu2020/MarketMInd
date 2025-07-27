@extends('layout.app')
@section('content')
<div class="pricing-plan-area ptb-120" style="background-image: url(assets/images/hero/hero-image-1.svg)">
    <div class="container">
        <div class="section-title">
            <h2><span class="sub-title">PRICING PLAN</span></h2>
            <h2>Choose The Best <span><img src="assets/images/svg/lines-2.svg" alt="image"></span> Plan to get started with</h2>
        </div>

        <div class="row g-9 justify-content-center " data-cues="slideInUp" data-duration="800">
            @foreach($plans as $plan)
            <div class="col-lg-4 col-md-6 ">
                <div class="pricing-card bg-color-ffffff radius-30 ">
                    <div class="title position-relative">
                        <h3>{{ $plan->name }} Plan</h3>
                        <h4>{{ rtrim(rtrim($plan->interest_rate, '0'), '.') }}% / <span>Per Term</span></h4>
                        <img class="about-image-2" src="assets/images/about/about-image-2.png" alt="image">
                    </div>

                    <div class="pricing-card-body">
                        <ul class="check">
                            <li>
                                <i class="ri-check-line"></i>
                                Duration: {{ $plan->duration }} Days
                            </li>
                            <li>
                                <i class="ri-check-line"></i>
                                Percentage: {{ rtrim(rtrim($plan->interest_rate, '0'), '.') }}%
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="check-icon">
                                    <i class="ri-check-line"></i>
                                </span>
                                <span>
                                    <strong>Earnings:</strong>
                                    {{ $plan->duration < 28 ? 'Daily' : 'Weekly' }}
                                </span>
                            </li>
                            <li>
                                <i class="ri-check-line"></i>
                                Minimum Deposit: ${{ number_format($plan->minimum_amount, 0) }}
                            </li>
                            <li>
                                <i class="ri-check-line"></i>
                                Maximum Deposit: ${{ number_format($plan->maximum_amount, 0) }}
                            </li>
                        </ul>

                        <a href="/login" class="default-btn two w-100 text-center">
                            Get Started <i class="ri-arrow-right-up-line"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
