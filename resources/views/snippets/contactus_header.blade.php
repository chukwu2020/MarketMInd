@extends('layout.app')
@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

       <!-- Start Contact Address Area -->
       <div class="contact-address-area ptb-120  overflow-hidden" style="background-image: url(assets/images/hero/hero-image-1.svg ); ">
            <div class="container">
                <div class="address-container bg-color-0c3a30 radius-20">
                    <div class="contact-warp d-flex align-items-center justify-content-between" data-cues="slideInDown" data-duration="700">
                        <div class="location position-relative">
                            <i class="flaticon-phone-call call-icon"></i>
                            <span>Phone Number</span>
                            <a href="tel:000946862091">+447 7742 (663) 627</a>
                        </div>
                        <div class="location position-relative">
                            <i class="flaticon-email-1 call-icon"></i>
                            <span>Email Address</span>
                            <a href="https://templates.hibootstrap.com/cdn-cgi/l/email-protection#cda5a8a1a1a28daba4a3b9a2e3aea2a0"><span class="__cf_email__" data-cfemail="056d6069696a45636c6b716a2b666a68">[email&#160;protected]</span></a>
                        </div>
                        <div class="location position-relative">
                            <i class="flaticon-maps-and-flags call-icon"></i>
                            <span>Visit Our Office</span>
                            <a href="https://www.google.com/maps/place/90+Greene+St,+New+York,+NY+10012,+USA/@40.7240112,-74.0026355,17z/data=!3m1!4b1!4m6!3m5!1s0x89c2598ea38acb7f:0x409e2155ddf4e393!8m2!3d40.7240072!4d-74.0000606!16s%2Fg%2F11c5p_8lws?entry=ttu&amp;g_ep=EgoyMDI0MDgyMS4wIKXMDSoASAFQAw%3D%3D" target="_blank">WORLDWIDE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contact Address Area -->

        <!-- Start Contact Form Area -->
        <div class="contact-form-area pb-120 " >
            <div class="container align-items-center ">
                <div class="section-title" style="max-width: 665px;">
                    <span class="sub-title two bg-color-9edd05 rounded-pill">GET IN TOUCH</span>
                    <h2>Don’t Hesitate To Contact Us</h2>
                </div>
                <div class="row g-4">
                    <div class="col-lg-8 col-md-12" data-cues="slideInUp" data-duration="800">
                        <form method="POST" action="{{ route('user.contact.send') }}" 
                        class="contact-form space-y-6 bg-color-fffaeb radius-30">
                          @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
                                       
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Email"  value="{{ old('email') }}" required>
                                   
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}" class="form-control" >
                                      
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <input type="text" name="subject" class="form-control"  value="{{ old('subject') }}" required placeholder="Subject">
                                    
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <textarea class="form-control textarea" name="message" required placeholder="Write A Message">{{ old('message') }}</textarea>
                           
                                </div>
                            </div>

                            <button type="submit" class="default-btn">Send Message <i class="ri-arrow-right-up-line"></i></button>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-12" data-cues="slideInDown" data-duration="800">
                        <div class="contact-map">
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        <!-- End Contact Form Area -->
