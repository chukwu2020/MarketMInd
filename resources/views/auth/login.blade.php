@extends('layout.app')

@section('content')
<!-- resources/views/auth/login.blade.php -->

@if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


<style>
    /* CSS to reduce header gap */
    .page-banner-area {
        margin-top: -1rem;
        padding-top: 4rem !important;
    }
    @media (max-width: 768px) {
        .page-banner-area {
            margin-top: -1.5rem;
        }
    }
</style>

<!-- Start Page Banner Area -->
<div class="page-banner-area position-relative" style="background-image: url(assets/images/hero/hero-image-2.svg);">
    <div class="container">
        <div class="page-banner-content">
            <h1 style="font-size: 24px; margin: 0;">My Account</h1>
            <ul style="margin: 5px 0 0; padding: 0;">
                <li style="display: inline;"><a href="/">Home</a></li>
                <li style="display: inline;">  My Account</li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Banner Area -->
<!-- End Page Banner Area -->

<!-- Start My Account Page -->
<div class="my-account-page pt-80 pb-80 overflow-hidden">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-8 col-md-12" data-cues="slideInRight" data-duration="800">
                <form action="{{ route('login') }}" method="POST" class="login-form bg-color-fffaeb radius-30">
                    @csrf
                    <h3>Log In To Your Account</h3>

                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
                            <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="">Password</label>
                            <div class="password-input-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                <span class="password-toggle">
                                    <i class="toggle-icon"></i>
                                </span>
                            </div>
                            <span class="text-danger">@error('password') {{ $message }} @enderror</span>
                        </div>
                    </div>

                    <div class="d-flex login-warp gap-4 align-items-center justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                  <label class="form-check-label" for="remember">
    Keep Me Logged In
</label>

                            @if(session('status') === 'Please verify your email before logging in.')
                                <form method="POST" action="{{ route('password.request') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link">Resend verification email</button>
                                </form>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('password.request') }}" class="password">Forgot Your Password?</a>
                        </div>
                    </div>

                    <button type="submit" class="default-btn w-100 text-center">Log In</button>

                    <p>Don't Have An Account? <a href="{{route('signup')}}">Create</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End My Account Page -->

<style>
    .page-banner-area {
        height: 150px !important; /* Reduced from original height */
    }
    
    .page-banner-content h1 {
        font-size: 28px !important; /* Smaller heading */
        margin-bottom: 10px !important;
    }
    
    .page-banner-content ul {
        margin-bottom: 0 !important;
    }
    
    .password-input-group {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }
    
    .toggle-icon {
        display: inline-block;
        width: 20px;
        height: 20px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'%3E%3C/path%3E%3Ccircle cx='12' cy='12' r='3'%3E%3C/circle%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
    }
    
    .password-toggle.show-password .toggle-icon {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24'%3E%3C/path%3E%3Cline x1='1' y1='1' x2='23' y2='23'%3E%3C/line%3E%3C/svg%3E");
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('.password-toggle');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle the eye icon
            this.classList.toggle('show-password');
        });
    });
</script>

@endsection