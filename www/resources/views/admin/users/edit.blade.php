@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('users.edit', $user) }}

@include('layouts.partials.adminnav')


<form method="POST" action="{{ route('users.update', ['user'=>$user->id]) }}">
    @csrf
    @method('PUT')
  <div class="mb-3">
    <label for="Name" class="form-label">{{ __('admin.name') }}</label>
    <input type="text" class="form-control" id="Name" aria-describedby="Name" value="{{ $user->name }}" name="name" required>
    @if ($errors->has('name'))
      <p class="text-danger">{{ $errors->first('name') }}</p>
    @endif
  </div>

  <div class="mb-3">
    <label for="Email" class="form-label">{{ __('admin.email') }}</label>
    <input type="email" class="form-control" id="Email" aria-describedby="Email" value="{{ $user->email }}" name="email" required>
    @if ($errors->has('email'))
      <p class="text-danger">{{ $errors->first('email') }}</p>
    @endif
  </div>
  
  <div class="mb-3">
    <label for="Status" class="form-label">{{ __('admin.status') }}</label>
    <select name="status" class="form-select">
      @foreach ($statuses as $value => $label)
      <option value="{{$value}}" {{ $user->status == $value?'selected' : '' }}>{{ $label }}</option>
      @endforeach
    </select>
  </div>

  <div class="mb-3">
    <label for="role" class="form-label">{{ __('admin.role') }}</label>
    <select name="role" class="form-select">
      @foreach ($roles as $value => $label)
      <option value="{{$value}}" {{ $user->status == $value?'selected' : '' }}>{{ $label }}</option>
      @endforeach
    </select>
  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>





@endsection
