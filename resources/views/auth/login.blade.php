@extends('layouts.app')

@section('content')
<!-- Sign In Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ url('/') }}" class="">
                        <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
                    </a>
                    <h3>{{ __('Sign In') }}</h3>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" name="email" value="{{ old('email') }}" placeholder="name@example.com" required autocomplete="email">
                        <label for="floatingInput">{{ __('Email address') }}</label>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" name="password" placeholder="Password" required autocomplete="current-password">
                        <label for="floatingPassword">{{ __('Password') }}</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleCheck1">{{ __('Remember Me') }}</label>
                        </div>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">{{ __('Forgot Password') }}</a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">{{ __('Sign In') }}</button>
                    <p class="text-center mb-0">{{ __("Don't have an Account?") }} <a href="{{ route('register') }}">{{ __('Sign Up') }}</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Sign In End -->
@endsection
