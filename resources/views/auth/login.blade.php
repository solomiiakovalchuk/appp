@extends('layouts.main')

@section('content')

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="text-center mb-4 mt-2">
                <img src="{{ asset('fav.png') }}" href="/" alt="Favicon" class="mb-3" style="height: 50px;">
                <h1>{{ __('LOGIN') }}</h1>
            </div>

            @if(session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card shadow-sm p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                        @error('password')
                        <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        @if (Route::has('password.request'))
                            <a class="text-decoration-underline text-muted" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        @endif

                        <button type="submit" class="btn btn-primary">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
