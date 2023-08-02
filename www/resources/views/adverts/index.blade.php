@extends('layouts.app')

@section('content')
@include('layouts.partials.adminnav')

<div class="container text-center">

<form method="GET" action="?" id="filter">
<div class="row justify-content-center py-3">
    <div class="col-3">
    <input type="text" class="form-control" placeholder="Name" id="name" aria-describedby="name" name="name" value="{{ request('name') }}">
    </div>

    <div class="col-2">
    <select name="status" class="form-select">
    <option value="">Status</option>
      @foreach ($statuses as $key=>$value)
        <option value="{{ $key }}" {{ intval(request('status')) === $key?'selected' : '' }}>{{ $value }}</option>
      @endforeach
    </select>
    </div>
    <div class="col-2">
    <select name="region" class="form-select">
    <option value="">Region</option>
      @foreach ($regions as $key => $region)
        <option value="{{ $key }}" {{ intval(request('region')) === $key?'selected' : '' }}>{{ $region }}</option>
      @endforeach
    </select>
    </div>

    <div class="col-2">
    <select name="category" class="form-select">
    <option value="">Category</option>
      @foreach ($categories as $key => $category)
        <option value="{{ $key }}" {{ intval(request('category')) === $key?'selected' : '' }}>{{ $category }}</option>
      @endforeach
    </select>
    </div>

    <div class="col-2"><span>
    <button type="submit" class="btn btn-primary btn-form">GO!</button>
    <a href="?" class="btn btn-secondary btn-form">Clear</a></span>
    </div>

  </div>
</div>
</form>


<table class="table table-striped table-hover">

    <thead>
        <tr>
        <th scope="col">{{ __('admin.id') }}</th>
        <th scope="col">{{ __('advert.title') }}</th>
        <th scope="col">{{ __('advert.author') }}</th>
        <th scope="col">{{ __('advert.cat') }}</th>
        <th scope="col">{{ __('admin.status') }}</th>
        <th scope="col">{{ __('advert.expiration') }}</th>
      </tr>
     </thead>
     <tbody class="table-group-divider">
@foreach ($adverts as $advert)
    <tr>
      <th scope="row">{{ $advert->id }}</th>
      <td class="text-start"><a href="{{ route('manage.show', [$advert]) }}">{{ $advert->title }}</a> 
      </td>
      <td>{{ $advert->user->name }}</td>
      <td>
        {{ $advert->category->name}}
      </td>
      <td>
       
          <span class="badge 
@if ($advert->isDraft())
rounded-pill text-bg-primary
@elseif ($advert->isOnModeration())
rounded-pill text-bg-secondary
@elseif ($advert->isActive())
rounded-pill text-bg-info
@else
rounded-pill text-bg-warning
@endif
">{{ $advert->statusName() }}</span>
       
      </td>
      <td>
     @isset ($advert->expires_at)   
    {{ $advert->expires_at }}
    @endisset
    </td>
    </tr>
    
@endforeach
</tbody>



</table>



{{ $adverts->onEachSide(5)->links() }}

{{ Breadcrumbs::render('adverts.manage') }}

@endsection


