@extends('layouts.app')

@section('content')


<form method="POST" action="{{ route('auth.phonelogin') }}">
    @csrf

  <div class="mb-3">
    <label for="token" class="form-label">{{ __('admin.token') }}</label>
    <input type="text" class="form-control" id="token" aria-describedby="token" value="" name="token" required>
    @if ($errors->has('token'))
      <p class="text-danger">{{ $errors->first('token') }}</p>
    @endif
  </div>
  
  <button type="submit" class="btn btn-primary">{{ __('admin.submit') }}</button>
</form>


@endsection
