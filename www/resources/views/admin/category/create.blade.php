@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('categories.create') }}
@include('layouts.partials.adminnav')

<form method="POST" action="{{ route('categories.store') }}">
    @csrf
  <div class="mb-3">
    <label for="Name" class="form-label">{{ __('admin.name') }}</label>
    <input type="text" class="form-control" id="Name" aria-describedby="Name" value="{{ old('name') }}" name="name" required>
    @if ($errors->has('name'))
      <p class="text-danger">{{ $errors->first('name') }}</p>
    @endif
  </div>

  <div class="mb-3">
    <label for="parent" class="form-label">{{ __('admin.parent') }}</label>
    <select class="form-select" aria-label="{{ __('admin.parent') }}" name="parent_id">
      <option>---</option>
      @foreach ($all as $category)
      <option value={{ $category->id }}"{{ $category->id == $id ? " selected" : "" }}>{{ $category->name }}</option>
      @endforeach
    </select>

  </div>

  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>



@endsection
