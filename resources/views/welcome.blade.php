@extends('layout.app')
@section('content')


<style>
    /* CSS to reduce header gap */
    .main-banner-area {
        margin-top: -1rem;
        padding-top: 4rem !important;
    }

    @media (max-width: 768px) {
        .main-banner-area {
            margin-top: -1.5rem;
        }
    }
</style>

<!-- Start Main Banner Area -->
<div class="main-banner-area overflow-hidden position-relative " style="background-image: url(assets/images/hero/hero-image-1.svg);padding-top: -20rem; ">
    <div class="main-banner-area overflow-hidden position-relative "
        style="background-image: url(assets/images/hero/hero-image-1.svg); ">
        <div class="container-fluid side-padding">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-12" data-cues="slideInRight" data-duration="800">
                    <div class="main-banner-content">
                        <span class="sub-t">WELCOME TO MARKETMIND</span>
                        <h1>Secure <span><img src="assets/images/svg/your.svg" alt="image"> Your</span> Financial Future with Intelligent Investing </h1>
            <h6 >    Zero stress. Maximum profit. Built for modern investors</h6>
                      
                   

                        <a href="{{route('signup')}}" class="default-btn mt-4 px-5 py-2 mb-2 rounded-pill shadow" style="color:#0C3A30;">
                            Open an account
                        </a>
                    </div>
                </div>

                
                <div class="col-xl-7 col-lg-12" data-cues="slideInLeft" data-duration="800">
                    <div class="info">
                        <p class="mb-3 mb-md-4">We are at the forefront of revolutionizing the financial landscape through cutting edge marketMind solutions. Our mission is to bridge the gap between traditional banking and modern technology offering innovative and seamless financial services that cater to the evolving.</p>

                        <div class="row align-items-center g-3 g-md-4">
                            <div class="col-lg-5 col-md-5">
                                <ul class="user bg-color-ffffff radius">
                                    <li>
                                        <img class="rounded-circle" src="assets/images/user/user-image-2.jpg" alt="image">
                                    </li>
                                    <li>
                                        <img class="rounded-circle" src="assets/images/user/user-image-3.jpg" alt="image">
                                    </li>
                                    <li>
                                        <img class="rounded-circle" src="assets/images/user/user-image-1.jpg" alt="image">
                                    </li>
                                    <li>
                                        32k+
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="star-review">
                                    <ul>
                                        <li>
                                            <i class="flaticon-star-2"></i>
                                            <i class="flaticon-star-2"></i>
                                            <i class="flaticon-star-2"></i>
                                            <i class="flaticon-star-2"></i>
                                            <i class="flaticon-star-2"></i>
                                        </li>
                                        <li>
                                            <strong>4.9/5</strong> <span>Rating</span>
                                        </li>
                                        <li>
                                            <span>From over 1000+ reviews</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-area">
            <div class="container-fluid side-padding">
                <div class="row g-3 g-md-4 justify-content-center" data-cues="slideInUp" data-duration="800">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="banner-card bg-color-ffffff radius-30">
                            <div class="flex-warp position-relative">
                                <i>
                                    <img src="assets/images/svg/grow.svg" alt="image">
                                </i>
                                <h3>Create A Card That Is Unique And Customized</h3>
                            </div>
                            <div class="banner-card-body bg-color-def1ee">
                                <img src="assets/images/service/service-image-1.png" alt="image">
                            </div>
                        </div>

                        <!-- Advice Area Start -->
                        <div class="advice-area bg-color-ffffff radius-20 mt-3">
                            <div class="container-fluid">
                                <div class="advice-content">
                                    <ul>
                                        <li>Revenue</li>
                                        <li>Investment</li>
                                        <li>Deposit</li>
                                        <li>Earnings</li>
                                        <li>Transaction</li>
                                        <li>Revenue</li>
                                        <li>Investment</li>
                                        <li>Deposit</li>
                                        <li>Earnings</li>
                                        <li>Transaction</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="banner-card part-two bg-color-9edd05 radius-30 position-relative">
                            <div class="flex-warp position-relative">
                                <i>
                                    <img src="assets/images/svg/corporation.svg" alt="image">
                                </i>
                                <h3>Transfers Across The Globe Are Free</h3>
                            </div>
                            <p class="mb-0">Our digital solutions transform money management investing and transaction.</p>
                            <div class="banner-card-image">
                                <div class="text-end">
                                    <img src="assets/images/service/service-image-2.png" alt="image">
                                </div>
                            </div>

                            <div class="total bg-color-ffffff radius">
                                <h4>Total Balance</h4>
                                <h5>$9,647.00</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="banner-card part-three bg-color-ffffff radius-30 position-relative">
                            <div class="flex-warp position-relative">
                                <i>
                                    <img src="assets/images/svg/euro.svg" alt="image">
                                </i>
                                <h3>Personalized Insights And Financial Goals</h3>
                            </div>
                            <div class="banner-image-body">
                                <div class="text-end">
                                    <img class="service-image-3" src="assets/images/service/service-image-3.png" alt="image">
                                </div>
                                <img class="service-image-4" src="assets/images/service/service-image-4.png" alt="image">
                            </div>
                            <i class="flaticon-star-5 star-5 moveHorizontal_reverse"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Pricing Plan Area -->
    <div class="pricing-plan-area pt-100 pb-80 mb-5 pt-md-120 pb-md-100 bg-color-def1ee" style="background-image: url(assets/images/hero/hero-image-1.svg)">
        <div class="container">
            <div class="section-title">
                <span class="sub-title">PRICING PLAN</span>
                <h2>Choose The Best <span><img src="assets/images/svg/lines-2.svg" alt="image">Plans</span> Which For You</h2>
            </div>
            <div class="row g-3 g-md-4 justify-content-center" data-cues="slideInUp" data-duration="800">
                @foreach($plans as $plan)
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card bg-color-ffffff radius-30">
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
                                    Percentage: {{ $plan->interest_rate }}%
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Minimum Deposit:  ${{ number_format($plan->minimum_amount) }}
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Maximum Deposit: ${{ number_format($plan->maximum_amount) }}
                                </li>
                            </ul>

                            <a href="/login" class="default-btn two w-100 text-center">Get Started <i class="ri-arrow-right-up-line"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Pricing Plan Area -->
    <!-- End Main Banner Area -->

    <!-- Start Features Area -->
    <div class="features-area bg-color-0c3a30 pt-100 pb-80 pt-md-120 pb-md-100 overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-12" data-cues="slideInRight" data-duration="800">
                    <div class="features-image bg-color-9edd05 radius-30 position-relative">
                        <img class="feature-image-1" src="assets/images/feature/feature-image-1.png" alt="image">
                        <img class="feature-image-2 bounce" src="assets/images/feature/feature-image-2.png" alt="image">
                        <img class="feature-shape-1 moveVertical" src="assets/images/shape/feature-shape-1.png" alt="image">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12" data-cues="slideInLeft" data-duration="800">
                    <div class="features-content">
                        <div class="section-heading">
                            <span class="sub-title">TOP FEATURES</span>
                            <h2 class="text-white">Let's Take Your <span><img src="assets/images/svg/lines-1.svg" alt="image">Analytics</span> To The Next Level</h2>
                            <p class="text-white">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients.</p>
                        </div>

                        <ul>
                            <li class="bg-color-29594b radius-20">
                                <i class="flaticon-businessman-1"></i>
                                <h3 class="text-white">Local Business Finance</h3>
                                <p class="text-white">Our commitment to security transparency and customer centricity ensures that every transaction is no.</p>
                            </li>
                            <li class="bg-color-29594b radius-20">
                                <i class="flaticon-payment-method"></i>
                                <h3 class="text-white">Built For Global Payments</h3>
                                <p class="text-white">Our commitment to security transparency and customer centricity ensures that every transaction is no.</p>
                            </li>
                            <li class="bg-color-29594b radius-20">
                                <i class="flaticon-laptop-2"></i>
                                <h3 class="text-white">Make Internet Of Money</h3>
                                <p class="text-white">Our commitment to security transparency and customer centricity ensures that every transaction is no.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="partner-area mt-5 pt-80 pt-md-120">
            <div class="container">
                <div class="title">
                    <p>TRUSTED BY INDUSTRY LEADING COMPANIES AROUND THE GLOBE</p>
                </div>
                <div class="partner-items">
                    <div class="swiper partner-slide">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="assets/images/partner/partner-logo-1.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="assets/images/partner/partner-logo-2.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="assets/images/partner/partner-logo-3.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="assets/images/partner/partner-logo-4.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="assets/images/partner/partner-logo-5.png" alt="image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Features Area -->

    <!-- Start Services Area -->
    <div class="services-area pt-100 pb-80 pt-md-120 pb-md-100 position-relative overflow-hidden">
        <div class="container left-padding">
            <div class="row align-items-center">
                <div class="col-xl-4 col-lg-12" data-cues="slideInLeft" data-duration="800">
                    <div class="section-heading position-relative mb-0">
                        <span class="sub-title">OUR SERVICES</span>
                        <h2>Syncing <span><img src="assets/images/svg/lines-2.svg" alt="">Your</span> Finances</h2>
                        <p class="mb-4 mb-md-5">With a robust suite of products ranging from digital banking and payment processing to wealth</p>

                        <a href="{{route('our.services')}}" class="default-btn two">See All Services <i class="ri-arrow-right-up-line"></i></a>

                        <div class="services-btn">
                            <div class="swiper-button-next">
                                <i class="ri-arrow-right-line"></i>
                            </div>
                            <div class="swiper-button-prev">
                                <i class="ri-arrow-left-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12">
                    <div class="services-items">
                        <div class="swiper services-slide">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="services-card position-relative">
                                        <img class="radius-30" src="assets/images/service/service-image-5.jpg" alt="image">
                                        <div class="services-card-body bg-color-fffaeb radius-30">
                                            <i class="flaticon-businessman-5 businessman"></i>
                                            <h3>
                                                <a href="{{route('our.services')}}">Funds Remittance</a>
                                            </h3>
                                            <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing.</p>
                                            <a href="{{route('our.services')}}" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="services-card position-relative">
                                        <img class="radius-30" src="assets/images/service/service-image-6.jpg" alt="image">
                                        <div class="services-card-body bg-color-fffaeb radius-30">
                                            <i class="flaticon-browser-1 businessman"></i>
                                            <h3>
                                                <a href="{{route('our.services')}}">Personal Loan</a>
                                            </h3>
                                            <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing.</p>
                                            <a href="{{route('our.services')}}" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Services Area -->

    <!-- Start About Us Area -->
    <div class="about-us-area pb-80 pb-md-120 overflow-hidden">
        <div class="container">
            <div class="about-top mb-4 mb-md-5">
                <div class="row align-items-center" data-cues="slideInUp" data-duration="800">
                    <div class="col-lg-7 col-md-7">
                        <div class="section-heading mb-0">
                            <span class="sub-title">ABOUT US</span>
                            <h2 class="mb-0">Leveraging Technology <span><img src="assets/images/svg/lines-3.svg" alt="image">For</span> Secure & Banking</h2>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5">
                        <div class="content">
                            <p>By integrating advanced technology with financial expertise we provide a comprehensive suite of services that cater to both individuals and businesses</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="about-info bg-color-edf1ee radius-30">
                <div class="row g-3 g-md-4">
                    <div class="col-lg-6" data-cues="slideInRight" data-duration="800">
                        <div class="about-content">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="miss-tab" data-bs-toggle="tab" data-bs-target="#miss-tab-pane" type="button" role="tab" aria-controls="miss-tab-pane" aria-selected="true">Our Mission</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="qua-tab" data-bs-toggle="tab" data-bs-target="#qua-tab-pane" type="button" role="tab" aria-controls="qua-tab-pane" aria-selected="false">Our Quality</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="miss-tab-pane" role="tabpanel" aria-labelledby="miss-tab" tabindex="0">
                                    <div class="title">
                                        <h2>Passionate For Your Financial Support Here</h2>
                                        <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications.</p>
                                    </div>

                                    <ul class="check">
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Pay Bills On Time Without Missing A Beat
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Create And Send Invoices In Seconds
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Control Your Cash Flow On Demand
                                        </li>
                                    </ul>

                                    <a href="{{route('about.us')}}" class="default-btn mt-4 mt-md-5">More About Us <i class="ri-arrow-right-up-line"></i></a>
                                </div>
                                <div class="tab-pane fade" id="qua-tab-pane" role="tabpanel" aria-labelledby="qua-tab" tabindex="0">
                                    <div class="title">
                                        <h2>Financial For Your Passionate Support Here</h2>
                                        <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications.</p>
                                    </div>

                                    <ul class="check">
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Pay Bills On Time Without Missing A Beat
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Create And Send Invoices In Seconds
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Control Your Cash Flow On Demand
                                        </li>
                                    </ul>

                                    <a href="{{route('about.us')}}" class="default-btn mt-4 mt-md-5">More About Us <i class="ri-arrow-right-up-line"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-cues="slideInLeft" data-duration="800">
                        <div class="about-image bg-color-ffffff radius-30">
                            <img class="about-image-1" src="assets/images/about/about-image-1.jpg" alt="image">
                            <img class="about-image-2" src="assets/images/about/about-image-1.png" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About Us Area -->

    <!-- Start Why Choose Us Area -->
    <div class="why-choose-us-area mb-4 mb-md-5 overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12" data-cues="slideInRight" data-duration="800">
                    <div class="choose-image position-relative">
                        <img class="radius-30" src="assets/images/about/about-image-2.jpg" alt="image">
                        <div class="paly-content">
                            <a data-fslightbox="one" href="https://www.youtube.com/watch?v=Y7cpCDlRfV0" class="popup-btn">
                                <i class="flaticon-play-buttton"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12" data-cues="slideInLeft" data-duration="800">
                    <div class="why-choose-us-content">
                        <div class="section-heading mb-0">
                            <span class="sub-title">WHY CHOOSE US</span>
                            <h2>Grow Your <span><img src="assets/images/svg/lines-1.svg" alt="image">Transaction</span> From Another Level</h2>
                            <p class="mb-4 mb-md-5">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients.</p>
                            <a href="{{ route('about.us') }}" class="default-btn two">Learn More <i class="ri-arrow-right-up-line"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Why Choose Us Area -->

    <!-- Start Choose Card Area -->
    <div class="choose-card-area pb-80 pb-md-120 mb-5">
        <div class="container">
            <div class="row g-3 g-md-4 justify-content-center" data-cues="slideInUp" data-duration="800">
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card bg-color-fffaeb radius-30">
                        <i class="flaticon-money-5"></i>
                        <h3>Global Payments</h3>
                        <p>With a robust suite of products ranging from digital banking and payment processing.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card bg-color-fffaeb radius-30">
                        <i class="flaticon-dollar-symbol-1"></i>
                        <h3>Revenue & Finance</h3>
                        <p>With a robust suite of products ranging from digital banking and payment processing.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card bg-color-fffaeb radius-30">
                        <i class="flaticon-tablet"></i>
                        <h3>Bank As A Service</h3>
                        <p>With a robust suite of products ranging from digital banking and payment processing.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Choose Card Area -->

    <!-- Start How It Works Area -->
    <div class="how-it-works-area bg-color-0c3a30 pt-100 pb-120 pt-md-120  -pb-md-100">
        <div class="container">
            <div class="about-top mb-4 mb-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-7" data-cues="slideInRight" data-duration="800">
                        <div class="section-heading mb-0">
                            <span class="sub-title text-white">HOW IT WORKS</span>
                            <h2 class="text-white mb-0">Commitment To <span><img src="assets/images/svg/lines-1.svg" alt="image">Exceptional</span> Services And Solutions</h2>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5" data-cues="slideInLeft" data-duration="800">
                        <div class="content">
                            <p class="text-white">By integrating advanced technology with financial expertise we provide a comprehensive suite of services that cater to both individuals and businesses</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-xl-4 col-lg-12">
                    <div class="works-btn">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="crea-tab" data-bs-toggle="tab" data-bs-target="#crea-tab-pane" type="button" role="tab" aria-controls="crea-tab-pane" aria-selected="true">Create Account <i class="ri-arrow-right-up-line"></i></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="use-tab" data-bs-toggle="tab" data-bs-target="#use-tab-pane" type="button" role="tab" aria-controls="use-tab-pane" aria-selected="false">User Confirmation <i class="ri-arrow-right-up-line"></i></button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="crea-tab-pane" role="tabpanel" aria-labelledby="crea-tab" tabindex="0">
                            <div class="row g-3 g-md-4" data-cues="slideInUp" data-duration="800">
                                <div class="col-lg-6">
                                    <div class="single-works-image">
                                        <img class="radius-30" src="assets/images/about/about-image-3.jpg" alt="image">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single-works-card bg-color-29594b radius-30">
                                        <i class="flaticon-payment-method-1 method"></i>
                                        <h3 class="text-white">Create Account</h3>
                                        <p class="text-white">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients to navigate the complexities of the financial world with ease confidence</p>
                                        <a href="/" class="default-btn two">Get Started <i class="ri-arrow-right-up-line"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="use-tab-pane" role="tabpanel" aria-labelledby="use-tab" tabindex="0">
                            <div class="row g-3 g-md-4" data-cues="slideInUp" data-duration="800">
                                <div class="col-lg-6">
                                    <div class="single-works-image">
                                        <img class="radius-30" src="assets/images/about/about-image-10.jpg" alt="image">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single-works-card bg-color-29594b radius-30">
                                        <i class="flaticon-tablet method"></i>
                                        <h3 class="text-white">User Confirmation</h3>
                                        <p class="text-white">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients to navigate the complexities of the financial world with ease confidence</p>
                                        <a href="/" class="default-btn two">Get Started <i class="ri-arrow-right-up-line"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End How It Works Area -->



    <!-- Start Testimonials Area -->
    <div class="testimonials-area pt-100 pb-80 pt-md-120 pb-md-100">
        <div class="container">
            <div class="about-top mb-4 mb-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-7" data-cues="slideInRight" data-duration="800">
                        <div class="section-heading mb-0">
                            <span class="sub-title">TESTIMONIALS</span>
                            <h2 class="mb-0">Hear What Our <span><img src="assets/images/svg/lines-1.svg" alt="image">Clients</span> Say About Us</h2>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-5" data-cues="slideInLeft" data-duration="800">
                        <div class="content">
                            <p>By integrating advanced technology with financial expertise we provide a comprehensive suite of services that cater to both individuals and businesses</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" data-cues="slideInUp" data-duration="800">
                <div class="col-lg-6 col-md-12">
                    <div class="testimonials-image bg-color-9edd05 radius-30 position-relative">
                        <img class="about-image-3" src="assets/images/about/about-image-3.png" alt="image">
                        <img class="feature-shape-1 rotate" src="assets/images/shape/feature-shape-1.png" alt="image">
                        <img class="feature-shape-2 rotate" src="assets/images/shape/feature-shape-1.png" alt="image">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="testimonials-content">
                        <div class="testimonials-card bg-color-fffaeb radius-30 mb-3 mb-md-4">
                            <ul>
                                <li>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                </li>
                            </ul>
                            <p>“We are at the forefront of revolutionizing the financial landscape through cutting MarketMind solutions Our mission is to bridge the gap between traditional banking and modern technology, offering innovative and seamless financial services that cater to the evolving needs of individuals.”</p>

                            <div class="flex-warp d-flex align-items-center justify-content-between">
                                <div class="d-flex gap-3 gap-md-4 align-items-center">
                                    <img class="user-image-4 rounded-circle" src="assets/images/user/user-image-4.jpg" alt="image">
                                    <div>
                                        <h3>Our Discord Community Name</h3>
                                        <span>CEO & Founder Of Our Community And On Discord Channels</span>
                                    </div>
                                </div>
                                <img class="right-quote" src="assets/images/svg/right-quote.svg" alt="image">
                            </div>
                        </div>

                        <div class="testimonials-card bg-color-fffaeb radius-30">
                            <ul>
                                <li>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                </li>
                            </ul>
                            <p>“We are at the forefront of revolutionizing the financial landscape through cutting MarketMind solutions Our mission is to bridge the gap between traditional banking and modern technology, offering innovative and seamless financial services that cater to the evolving needs of individuals.”</p>

                            <div class="flex-warp d-flex align-items-center justify-content-between">
                                <div class="d-flex gap-3 gap-md-4 align-items-center">
                                    <img class="user-image-4 rounded-circle" src="assets/images/user/user-image-5.jpg" alt="image">
                                    <div>
                                        <h3>Kevin M. Rueda</h3>
                                        <span>Investor</span>
                                    </div>
                                </div>
                                <img class="right-quote" src="assets/images/svg/right-quote.svg" alt="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonials Area -->

    <!-- Start Blog Area -->
    <div class="blog-area pb-80 pb-md-120 ">
        <div class="container">
            <div class="section-title">
                <span class="sub-title pt-100">LATEST BLOG</span>
                <h2>Smart Tools For <span><img src="assets/images/svg/lines-1.svg" alt="image">Creative</span> Financial Planning</h2>
            </div>
            <div class="row g-3 g-md-4" data-cues="slideInUp" data-duration="800">
                <div class="col-xl-6 col-lg-12 col-md-12">
                    <div class="blog-card bg-color-edf1ee radius-30 mb-3 mb-md-4">
                        <div class="row align-items-center">
                            <div class="col-lg-5 col-md-5">
                                <div class="blog-image">
                                    <a href="/" class="d-block">
                                        <img src="assets/images/blog/blog-image-1.jpg" class="blog-image-1" alt="image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7">
                                <div class="blog-card-body">
                                    <ul>
                                        <li><i class="ri-calendar-2-line"></i> Aug 06, 2024</li>
                                        <li><i class="ri-message-line"></i> No Comment</li>
                                    </ul>
                                    <h3>
                                        <a href="/">How To Easily Understand Your Insurance Contract</a>
                                    </h3>
                                    <p>With a robust suite of products ranging from digital banking and payment processing.</p>
                                    <a href="/" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="blog-card bg-color-edf1ee radius-30">
                        <div class="row align-items-center">
                            <div class="col-lg-5 col-md-5">
                                <div class="blog-image">
                                    <a href="/" class="d-block">
                                        <img src="assets/images/blog/blog-image-2.jpg" class="blog-image-1" alt="image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7">
                                <div class="blog-card-body">
                                    <ul>
                                        <li><i class="ri-calendar-2-line"></i> Aug 07, 2024</li>
                                        <li><i class="ri-message-line"></i> No Comment</li>
                                    </ul>
                                    <h3>
                                        <a href="/">The Basics Of Financial Responsibility</a>
                                    </h3>
                                    <p>With a robust suite of products ranging from digital banking and payment processing.</p>
                                    <a href="/" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12 col-md-12">
                    <div class="single-blog bg-color-edf1ee radius-30">
                        <a href="/" class="d-block">
                            <img src="assets/images/blog/blog-image-3.jpg" class="blog-image-3" alt="image">
                        </a>
                        <div class="single-blog-card-body">
                            <ul>
                                <li><i class="ri-calendar-2-line"></i> Aug 08, 2024</li>
                                <li><i class="ri-message-line"></i> No Comment</li>
                            </ul>
                            <h3>
                                <a href="/">Effective Financial Management Crucial For Most Organizations</a>
                            </h3>
                            <p>We are at the forefront of revolutionizing the financial landscape through cutting solutions Our mission is to bridge the gap between traditional banking.</p>
                            <a href="/" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog Area -->

    <!-- Start Faq Area -->
    <div class="faq-area pb-80 pb-md-120 overflow-hidden mt-5 mb-5">
        <div class="container">
            <div class="row g-3 g-md-4 align-items-center">
                <div class="col-lg-6 col-md-12" data-cues="slideInRight" data-duration="800">
                    <div class="question-card bg-color-9edd05 radius-30">
                        <div class="section-heading">
                            <span class="sub-title">FAQ</span>
                            <h2>Frequently <span><img src="assets/images/svg/lines-4.svg" alt="image">Asked</span> Questions</h2>
                            <p>With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications.</p>
                        </div>
                        <img class="radius-30" src="assets/images/blog/blog-image-4.jpg" alt="image">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12" data-cues="slideInLeft" data-duration="800">
                    <div class="faq-content">
                        <div class="accordion" id="accordionFAQ">
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBang" aria-expanded="false" aria-controls="collapseBang">
                                    1. Why should I care about financial planning?
                                </button>
                                <div id="collapseBang" class="accordion-collapse collapse show" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body">
                                        <p>Our mission is to bridge the gap between traditional banking and modern offering innovative and seamless financial services that cater to the evolving needs of individuals and businesses alike. With a robust suite.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSunam" aria-expanded="false" aria-controls="collapseSunam">
                                    2. What are the different types of investments?
                                </button>
                                <div id="collapseSunam" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body">
                                        <p> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Faq Area -->

    <!-- Start App Area -->
    <div class="app-area pb-80 pb-md-120 overflow-hidden">
        <div class="container">
            <div class="download-area bg-color-edf1ee radius-30">
                <div class="row g-3 g-md-4 align-items-center">
                    <div class="col-lg-6 col-md-12" data-cues="slideInRight" data-duration="800">
                        <div class="section-heading mb-0">
                            <span class="sub-title">DOWNLOAD OUR APP</span>
                            <h2>Experience <span><img src="assets/images/svg/lines-1.svg" alt="image">The</span> Future Of Banking</h2>
                            <p class="mb-4 mb-md-5">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications.</p>

                            <div class="app-btn">
                                <a href="https://play.google.com/store/apps/category/FAMILY?hl=en" target="_blank" class="me-2 me-md-3">
                                    <img class="rounded-3" src="assets/images/app/app-image-2.jpg" alt="image">
                                </a>
                                <a href="https://www.apple.com/app-store/" target="_blank">
                                    <img class="rounded-3" src="assets/images/app/app-image-3.jpg" alt="image">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12" data-cues="slideInLeft" data-duration="800">
                        <div class="app-image">
                            <img class="radius-30" src="assets/images/app/app-image-1.jpg" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End App Area -->
</div>
@endsection