@extends('layouts.app')

@section('content')
<div class="container">
    <div id="loginForm">
        <div class="">
            <div class="text-center">
                <h4>{{ __('Welcome to PACE') }}</h4>
                <small>Log in to your account</small>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="my-4">
                    <input id="email" type="email" class="form-control login-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="my-4">
                        <input id="password" type="password" class="form-control login-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="my-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
