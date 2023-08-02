@extends('layouts.app')
@section('content')
<div class="container">
<p>{{ __('advert.category') }}</p>

@include('profil.adverts._category', ['categories' => $categories])
</div>
@endsection


