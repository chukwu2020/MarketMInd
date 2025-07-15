@extends('layout.app')

@section('content')

<!-- Start Verify Email Page -->
<div class="my-account-page ptb-120 overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="login-form bg-white radius-30 p-4 shadow-sm border">

                    <h3 class="text-center mb-4 text-[#0c3a30]">Verify Your Email</h3>

                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-center">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger text-center">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('otp.submit') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="otp" class="form-label text-[#0c3a30]">
                                Enter the OTP sent to <strong>{{ $email }}</strong>
                            </label>
                            <input type="text" name="otp" maxlength="6" class="form-control text-center" required placeholder="6-digit OTP">
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Verify Email
                        </button>
                    </form>

                    <form method="POST" action="{{ route('otp.resend') }}" class="mt-3 text-center">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <button type="submit" class="btn btn-link text-decoration-none text-[#0c3a30]">
                            Didn't get the code? <span style="color: #0C3A30;">Resend OTP</span> 
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Verify Email Page -->

@endsection
