@extends('layouts.app')

@section('content')
<div class="container">

<h2>{{__('advert.edit') }}</h2>


<form method="POST" action="{{ route('manage.info.update', [$advert]) }}">
    @csrf
    @method('PUT')
<div class="container">
  <div class="row">
    <div class="col">
    <div class="mb-3">
        <label for="title" class="form-label">{{ __('advert.title') }}</label>
        <input type="text" class="form-control" id="title" placeholder="" name="title" value="{{ $advert->title ?? old('title') }}" required>
        @if ($errors->has('title'))
        <p class="text-danger">{{ $errors->first('title') }}</p>
        @endif
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">{{ __('advert.price') }}</label>
        <input type="text" class="form-control" id="price" placeholder="" name="price" value="{{ $advert->price ?? old('price') }}" required>
        @if ($errors->has('price'))
        <p class="text-danger">{{ $errors->first('price') }}</p>
        @endif
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">{{ __('advert.address') }}</label>
        <input type="text" class="form-control" id="address" placeholder="" name="address" value="{{ $advert->address ?? old('address')}}">
        @if ($errors->has('address'))
        <p class="text-danger">{{ $errors->first('address') }}</p>
        @endif
    </div>

    </div>
    <div class="col">

        <label for="content" style="padding-bottom: 0.7rem;">{{ __('advert.content') }}</label>
        <textarea class="form-control" id="content" name="content" style="height: 80%">{{ $advert->content ?? old('content') }}</textarea>
        
        @if ($errors->has('content'))
        <p class="text-danger">{{ $errors->first('content') }}</p>
        @endif

    </div>
  </div>

@foreach ($errors->all() as $error)
    {{ $error  }}
@endforeach

</div>

<button type="submit" class="form-control btn btn-secondary" style="margin-top: 1em;">{{ __('admin.update') }}</button>
</form>


</div>
@endsection


