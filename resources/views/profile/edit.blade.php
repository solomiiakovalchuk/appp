@extends('layouts.main')
@section('content')

    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        @if (is_null($user->getAuthPassword()))
                            @include('profile.partials.set-password-form')
                        @else
                            @include('profile.partials.update-password-form')
                        @endif
                    </div>
                </div>
            </div>

            @if (! is_null($user->getAuthPassword()))
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-body">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
