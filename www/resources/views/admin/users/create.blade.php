@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('users.create') }}
@include('layouts.partials.adminnav')

<form method="POST" action="{{ route('users.store') }}">
    @csrf
  <div class="mb-3">
    <label for="Name" class="form-label">{{ __('admin.name') }}</label>
    <input type="text" class="form-control" id="Name" aria-describedby="Name" value="{{ old('name') }}" name="name" required>
    @if ($errors->has('name'))
      <p class="text-danger">{{ $errors->first('name') }}</p>
    @endif
  </div>

  <div class="mb-3">
    <label for="Email" class="form-label">{{ __('admin.email') }}</label>
    <input type="email" class="form-control" id="Email" aria-describedby="Email" value="{{ old('email') }}" name="email" required>
    @if ($errors->has('email'))
      <p class="text-danger">{{ $errors->first('email') }}</p>
    @endif
  </div>
  
  <div class="mb-3">
    <label for="Password" class="form-label">Password</label>
    <input type="password" class="form-control" id="Password" name="password" required>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>



@endsection
