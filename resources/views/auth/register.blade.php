@extends('layouts.main')

@section('content')

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="col-md-6">
            <div class="text-center mb-4 mt-2">
                <img src="{{ asset('fav.png') }}" href="/" alt="Favicon" class="mb-3" style="height: 50px;">
                <h1>{{ __('REGISTER') }}</h1>
            </div>
            <div class="card shadow-sm p-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus autocomplete="name">
                        @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <div class="form-group">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username">
                        @error('email')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="form-group">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
                        @error('password')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
                        @error('password_confirmation')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Already registered? -->
                <div class="d-flex justify-content-between align-items-center">
                    <a class="text-decoration-underline text-muted me-3" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>

@endsection
