@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('profil.advert.create') }}
<div class="container">

<h2>{{__('advert.create')}}</h2>
<p>{{ $region->name }}</p>
<p>{{ $category->name }}</p>

<form method="POST" action="{{ route('profil.advert.create.store', [$category, $region]) }}">
    @csrf
<div class="container">
  <div class="row">
    <h3>{{ __('advert.body') }}</h3>
    <div class="col">
    <div class="mb-3">
        <label for="title" class="form-label">{{ __('advert.title') }}</label>
        <input type="text" class="form-control" id="title" placeholder="" name="title" value="{{ old('title') }}" required>
        @if ($errors->has('title'))
        <p class="text-danger">{{ $errors->first('title') }}</p>
        @endif
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">{{ __('advert.price') }}</label>
        <input type="text" class="form-control" id="price" placeholder="" name="price" value="{{ old('price') }}" required>
        @if ($errors->has('price'))
        <p class="text-danger">{{ $errors->first('price') }}</p>
        @endif
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">{{ __('advert.address') }}</label>
        <input type="text" class="form-control" id="address" placeholder="" name="address" value="{{ old('title') ?? $region->getPlz() }}">
        @if ($errors->has('address'))
        <p class="text-danger">{{ $errors->first('address') }}</p>
        @endif
    </div>

    </div>
    <div class="col">

        <label for="content" style="padding-bottom: 0.7rem;">{{ __('advert.content') }}</label>
        <textarea class="form-control" id="content" name="content" style="height: 100%">{{ old('content') }}</textarea>
        
        @if ($errors->has('content'))
        <p class="text-danger">{{ $errors->first('content') }}</p>
        @endif

    </div>
  </div>

  <div class="row">
    <h3>{{ __('advert.attributes') }}</h3>
    <div class="col">
    @foreach ($category->allAttributes() as $attr)
    <label for="attribute_{{ $attr->id }}">{{ $attr->name }}</label>
    @if ($attr->isSelect())
        <select class="form-select" name="attribute[{{ $attr->id }}]" id="attribute_{{ $attr->id }}">
        <option>---</option>
        @foreach ($attr->variants as $var)  
        <option value="{{ $var }}">{{ $var }}</option>
        @endforeach
    </select>
    @elseif ($attr->isNumber())
        <input class="form-control" type="number" name="attribute[{{ $attr->id }}]" id="attribute_{{ $attr->id }}" value="{{ old('attribute.'.$attr->id)}}"/>
    @else
        <input class="form-control" type="text" name="attribute[{{ $attr->id }}]" id="attribute_{{ $attr->id }}" value="{{ old('attribute.'.$attr->id)}}"/>
    @endif
    @if ($errors->has('attribute'.$attr->id))
      <p class="text-danger">{{ $errors->first('attribute'.$attr->id) }}</p>
    @endif
    @endforeach
    </div>
   </div>

@foreach ($errors->all() as $error)
    {{ $error  }}
@endforeach

</div>

<button type="submit" class="form-control btn btn-secondary" style="margin-top: 1em;">{{ __('advert.create') }}</button>
</form>


</div>
@endsection


