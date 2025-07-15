@extends('layout.app')
@section('content')







<div class="about-area two ptb-120" style="background-image: url(assets/images/hero/hero-image-1.svg)">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12" data-cues="slideInDown" data-duration="800">
                <div class="about-us-content position-relative">
                  <div class="section-heading pt-8 md:pt-12 lg:pt-16">
    <span class="sub-title two bg-color-9edd05 rounded-pill">ABOUT MARKET MIND</span>
    <h1>Your Right Path To Smart Financial Decisions</h1>
    <p>As a leading global Asset Management firm with $2.2 trillion in assets, Market Mind has been creating lasting impact since 2015. We pioneered a consulting-based approach to private asset investing, partnering with management teams to challenge conventional thinking and build great businesses.</p>
    
    <p>Our unique platform spans asset classes, delivering enduring results for diverse investors. Through insightful analysis and unconventional thinking, our team uncovers hidden opportunities while carefully assessing risks.</p>
    
    <p>At our core is a culture of integrity, collaboration, and client focus - our sustainable competitive advantage that attracts and retains top talent in the industry.</p>
</div>

                    <ul class="check">
                        <li>
                            <i class="ri-check-line"></i>
                            With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients
                        </li>
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


                    <a href="{{route('about.us')}}" class="default-btn mt-5">Learn About Us<i class="ri-arrow-right-up-line"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12" data-cues="slideInUp" data-duration="800">
                <div class="about-image position-relative">
                    <img class="radius-30" src="assets/images/about/about-image-4.jpg" alt="image">
                    <img class="about-image-5 radius-20 bounce" src="assets/images/about/about-image-5.jpg" alt="image">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection