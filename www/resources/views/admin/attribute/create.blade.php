@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('attributes.create', $category) }}
@include('layouts.partials.adminnav')

<form method="POST" action="{{ route('attributes.store') }}">
    @csrf
<input type="hidden" value="{{ $category->id }}" name="category" />
<div class="container">
<div class="row  align-items-center">
  <div class="col mb-3">
 
    <label for="Name" class="form-label">{{ __('admin.name') }}</label>
    <input type="text" class="form-control" id="Name" aria-describedby="Name" value="{{ old('name') }}" name="name" required>
    @if ($errors->has('name'))
      <p class="text-danger">{{ $errors->first('name') }}</p>
    @endif
  </div>

  <div class="col mb-3">
    <label for="parent" class="form-label">{{ __('admin.type') }}</label>
    <select class="form-select" aria-label="{{ __('admin.type') }}" name="type" required>
      @foreach ($types as $typ => $name)
      <option value="{{ $typ }}">{{ $name }}</option>
      @endforeach
    </select>
    @if ($errors->has('type'))
      <p class="text-danger">{{ $errors->first('type') }}</p>
    @endif
  </div>
  </div>


  <div class="mb-3">
  <input class="form-check-input" type="checkbox" value="1" name="required">
  <label for="required" class="form-label">{{ __('admin.required') }}</label>
  </div>


  

  <div class="mb-3">
    <label for="sort" class="form-label">{{ __('admin.sort') }}</label>
    <input type="text" class="form-control" id="sort" aria-describedby="sort" value="{{ old('sort') }}" name="sort" required>
    @if ($errors->has('sort'))
      <p class="text-danger">{{ $errors->first('sort') }}</p>
    @endif
  </div>

  <div class="mb-3">
  <label for="variants" class="form-label">{{ __('admin.variants')}}</label>
  <textarea class="form-control" id="variants" name="variants" rows="3" placeholder="{{ __('admin.variantstext') }}"></textarea>
  @if ($errors->has('variants'))
      <p class="text-danger">{{ $errors->first('variants') }}</p>
    @endif
</div>

  
  <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>



@endsection
