@extends('layouts.app')

@section('content')
@if (isset($main))
{{ Breadcrumbs::render('regions.show', $main) }}
@else
{{ Breadcrumbs::render('regions.index') }}
@endif
@include('layouts.partials.adminnav')

<div class="container text-center">
@if (isset($main))
<h2>{{__('admin.regions')}}: {{$main->name}} - {{ $count }}</h2>
@endif
<table class="table table-striped table-hover">

    <thead>
        <tr>
        <th scope="col">{{ __('admin.id') }}</th>
        <th scope="col">{{ __('admin.code') }}</th>
        <th scope="col">{{ __('admin.name') }}</th>
        <th scope="col">{{ __('admin.count') }}</th>
      </tr>
     </thead>
     <tbody class="table-group-divider">
@foreach ($regions as $region)
    <tr>
      <th scope="row">{{ $region->id }}</th>
      <td>{{$region->code}}</td>
      <td>
      @php($c = $region->children()->count())
        @if ($c  > 0)
        <a href="{{ route('regions.show', $region->id) }}">{{ $region->name }}</a> 
        @else
        {{ $region->name }}
        @endif
      </td>
      <td>
       @if ($c > 0)
       {{$c}}
       @else
        ---
       @endif
      </td>
    

    </tr>
@endforeach
     </tbody>



</table>





@endsection
