@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('profil.home') }}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <ul>
                        <li><a href="{{ route('profil.personal') }}">{{ __('navigation.settings') }}</a></li>
                        <li><a href="{{ route('profil.adverts') }}">{{ __('navigation.adverts') }}</a></li>
                        <li><a href="{{ route('profil.showfavourites') }}">{{ __('navigation.favourites') }}</a></li>
                    </ul>
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>

@endsection
