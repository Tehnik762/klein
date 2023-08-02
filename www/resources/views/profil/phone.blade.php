@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('profil.personal.verify') }}


<form method="POST" action="{{ route('profil.personal.verifyupdsate') }}">
    @csrf
    @method('PUT')
  <div class="mb-3">
    <label for="token" class="form-label">{{ __('admin.token') }}</label>
    <input type="text" class="form-control" id="toke" aria-describedby="token" value="" name="token" required>
    @if ($errors->has('token'))
      <p class="text-danger">{{ $errors->first('token') }}</p>
    @endif
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>



@endsection