@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('profil.personal.advert') }}
<div class="container text-center">

<table class="table table-striped table-hover">

    <thead>
        <tr>
        <th scope="col">№</th>   
        <th scope="col">{{ __('advert.title') }}</th>   
        <th scope="col">{{ __('advert.status') }}</th>      
      </tr>
     </thead>
     <tbody class="table-group-divider">
      @foreach ($adverts as $ad)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td><a href="{{ route('profil.adverts.show', [$ad->id]) }}">{{ $ad->title }}</a></td>
          <td>{{$statuses[$ad->status]}}</td>
        </tr>
      @endforeach
     </tbody>



</table>

<a href="{{ route('profil.advert.create') }}" class="btn btn-info">{{ __('profil.create')}}</a>


@endsection
