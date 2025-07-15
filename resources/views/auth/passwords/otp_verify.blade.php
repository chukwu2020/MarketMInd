@extends('layout.app')

@section('content')

<!-- Start OTP Reset Password Page -->
<div class="my-account-page ptb-120 overflow-hidden">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="login-form bg-color-fffaeb radius-30 p-4 border shadow-sm">

                    <h3 class="text-center mb-4">Enter OTP and Reset Password</h3>

                    <p class="text-center small text-muted mb-3">
                        Code sent to: 
                        <strong>{{ $email ?? session('otp_email') }}</strong>
                    </p>
                    
                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger text-center">
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.otp.verify') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email ?? session('otp_email') }}">

                        <div class="form-group mb-3">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input type="text" name="otp" maxlength="6" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <div class="password-input-group position-relative">
                                <input type="password" name="password" id="password" class="form-control" required>
                                <span class="password-toggle">
                                    <i class="toggle-icon"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="password-input-group position-relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                <span class="password-toggle">
                                    <i class="toggle-icon"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="default-btn w-100 text-center" style="color:#0C3A30;">
                            Update Password
                        </button>
                    </form>

                    <!-- Request New OTP Button -->
                    <form method="POST" action="{{ route('password.otp.send') }}" class="mt-3 text-end">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email ?? session('otp_email') }}">
                        <button type="submit" class="btn btn-link">
                          
                             Didn't get the code? <span style="color: #0C3A30;">  Request New OTP</span> 
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End OTP Reset Password Page -->

<style>
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
        const toggles = document.querySelectorAll('.password-toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling; // input before span
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.add('show-password');
                } else {
                    input.type = 'password';
                    this.classList.remove('show-password');
                }
            });
        });
    });
</script>

@endsection
