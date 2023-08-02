@extends('layouts.app')

@section('content')

<div class="container text-center">

  <table class="table table-striped table-hover">

    <thead>
      <tr>
        <th scope="col">№</th>
        <th scope="col">{{ __('advert.title') }}</th>
        <th scope="col-2">{{ __('advert.unmakefav')}}</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">
      @foreach ($adverts as $ad)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td><a href="{{ route('advert.show', $ad) }}">{{ $ad->title }}</a></td>
        <td>@include('layouts.partials.unmakefav', ['advert' => $ad])</td>
      </tr>
      @endforeach
    </tbody>



  </table>
  <div class="text-end">
    <a href="{{ route('profil.home') }}" class="btn btn-primary">{{ __('Dashboard') }}</a>
  </div>
  @endsection