@extends('layouts.app')

@section('content')
@if (isset($main))
{{ Breadcrumbs::render('categories.inside', $main) }}
@else
{{ Breadcrumbs::render('categories.index') }}
@endif
@include('layouts.partials.adminnav')

<div class="container text-center">

<table class="table table-striped table-hover">

    <thead>
        <tr>
        <th scope="col">{{ __('admin.id') }}</th>
        <th scope="col">{{ __('admin.name') }}</th>
        <th scope="col">{{ __('admin.slug') }}</th>  
        <th scope="col">{{ __('admin.edit') }}</th> 
        <th scope="col">{{ __('admin.position') }}</th> 
      </tr>
     </thead>
     <tbody class="table-group-divider">
@foreach ($categories as $category)
    <tr>
      <th scope="row">{{ $category->id }}</th>
      <td class="text-start">
      @if (!$category->isLeaf())  
      <a href="{{ route('categories.inside', $category->id) }}">
      {{ $category->name }}</a>
      @else 
      {{ $category->name }}
      @endif
    </td>
      <td>
      {{ $category->slug }}
      </td>
      <td>
      @include('layouts.partials.edithref', [
        'route' => 'categories.edit',
        'route_id' => $category->id,
        'route_name' => __('admin.edit'),
        'class' => 'secondary'
        ])
        @include('layouts.partials.edithref', [
        'route' => 'categories.show',
        'route_id' => $category->id,
        'route_name' => __('admin.show'),
        'class' => 'info'
        ])
      </td>
      <td>
      @include('layouts.partials.arrows', ['category' => $category])
      </td>
    </tr>
@endforeach
     </tbody>



</table>

@if (isset($main))
<a href="{{ route('categories.create', ['id' => $main->id]) }}"><button type="button" class="btn btn-danger">{{ __('admin.addcat') }}</button></a>
@else
<a href="{{ route('categories.create') }}"><button type="button" class="btn btn-danger">{{ __('admin.addcat') }}</button></a>
@endif


@endsection
