@extends('layouts.app')

@section('content')
<!-- Sign Up Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ url('/') }}" class="">
                        <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
                    </a>
                    <h3>{{ __('Sign Up') }}</h3>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingText" name="name" value="{{ old('name') }}" placeholder="jhondoe" required autocomplete="name" autofocus>
                        <label for="floatingText">{{ __('Username') }}</label>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email">
                        <label for="floatingInput">{{ __('Email address') }}</label>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" name="password" placeholder="Password" required autocomplete="new-password">
                        <label for="floatingPassword">{{ __('Password') }}</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="floatingPasswordConfirm" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                        <label for="floatingPasswordConfirm">{{ __('Confirm Password') }}</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="terms" required>
                            <label class="form-check-label" for="exampleCheck1">{{ __('I agree to the terms') }}</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">{{ __('Sign Up') }}</button>
                    <p class="text-center mb-0">{{ __("Already have an Account?") }} <a href="{{ route('login') }}">{{ __('Sign In') }}</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Sign Up End -->
@endsection
