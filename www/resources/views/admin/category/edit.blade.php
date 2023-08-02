@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('categories.edit', $category) }}

@include('layouts.partials.adminnav')


<form method="POST" action="{{ route('categories.update', ['category'=>$category->id]) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
    <label for="Name" class="form-label">{{ __('admin.name') }}</label>
    <input type="text" class="form-control" id="Name" aria-describedby="Name" value="{{ old('name') ?? $category->name }}" name="name" required>
    @if ($errors->has('name'))
      <p class="text-danger">{{ $errors->first('name') }}</p>
    @endif
  </div>

  <div class="mb-3">
    <label for="Slug" class="form-label">{{ __('admin.slug') }}</label>
    <input type="text" class="form-control" id="Slug" aria-describedby="Slug" value="{{ old('slug') ?? $category->slug }}" name="slug" required>
    @if ($errors->has('slug'))
      <p class="text-danger">{{ $errors->first('slug') }}</p>
    @endif
  </div>

  <div class="mb-3">
    <label for="parent" class="form-label">{{ __('admin.parent') }}</label>
    <select class="form-select" aria-label="{{ __('admin.parent') }}" name="parent_id">
      <option>---</option>
      @foreach ($all as $cat)
      <option value="{{ $cat->id }}"{{ $category->parent_id == $cat->id ? " selected" :"" }}>{{ $cat->name }}</option>
      @endforeach
    </select>

  </div>

  
  <button type="submit" class="btn btn-primary">Submit</button>
  
</form>
      <form action="{{ route('categories.destroy', $category) }}" method="POST">
        @method('DELETE')
        @csrf()
        <button type="submit" class="btn btn-danger" style="margin-top:0.5em;">
          {{ __('admin.delete') }}
        </button>
      </form>
      


@endsection
