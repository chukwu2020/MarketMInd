@extends('layout.app')

@section('content')

@if(session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    {{ $errors->first() }}
</div>
@endif


@if (session('success'))
<div class="alert alert-success text-center">
    {{ session('success') }}
</div>
@endif


<!-- Start Forgot Password Page -->
<div class="my-account-page ptb-120 overflow-hidden">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-8 col-md-12" data-cues="slideInRight" data-duration="800">
                <!-- <form action="{{ route('password.email') }}" method="POST" class="login-form bg-color-fffaeb radius-30"> -->
                <form action="{{ route('password.otp.send') }}" method="POST" class="login-form bg-color-fffaeb radius-30">

                    @csrf
                    <h3>Reset Your Password</h3>

                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" required>
                            <span class="text-danger">@error('email') {{ $message }} @enderror</span>
                        </div>
                    </div>

                    <button type="submit" class="default-btn w-100 text-center">Send Password Reset code</button>

                    <p class="mt-3">Remembered your password? <a href="{{ route('login') }}">Login</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Forgot Password Page -->

@endsection