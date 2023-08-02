@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('profil.personal.edit') }}



<form method="POST" action="{{ route('profil.personal.update') }}">
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
    <label for="lastname" class="form-label">{{ __('admin.lastname') }}</label>
    <input type="text" class="form-control" id="lastname" aria-describedby="lastname" value="{{ $user->lastname }}" name="lastname" required>
    @if ($errors->has('lastname'))
      <p class="text-danger">{{ $errors->first('lastname') }}</p>
    @endif
  </div>
  <div class="mb-3">
  <label for="phone" class="form-label">{{ __('admin.phone') }}</label>
    <input type="tel" class="form-control" id="phone" aria-describedby="phone" value="{{ $user->phone ?? old('phone') }}" name="phone">
    @if ($errors->has('phone'))
      <p class="text-danger">{{ $errors->first('phone') }}</p>
    @endif
  </div>
  <h5>{{__('admin.passchange')}}</h5>
  <div class="mb-3">
    <label for="oldpass" class="form-label">{{ __('admin.oldpass') }}</label>
    <input type="password" class="form-control" id="oldpass" aria-describedby="oldpass" value="" name="oldpass" oninput="removeDisable();" onblur="removeDisable();">
    @if ($errors->has('oldpass'))
      <p class="text-danger">{{ $errors->first('oldpass') }}</p>
    @endif

    <label for="newpass" class="form-label">{{ __('admin.newpass') }}</label>
    <input type="password" class="form-control" id="newpass" aria-describedby="newpass" value="" name="newpass" disabled>
    @if ($errors->has('newpass'))
      <p class="text-danger">{{ $errors->first('newpass') }}</p>
    @endif

    <label for="newpass2" class="form-label">{{ __('admin.newpass2') }}</label>
    <input type="password" class="form-control" id="newpass2" aria-describedby="newpass2" value="" name="newpass2" disabled>
    @if ($errors->has('newpass2'))
      <p class="text-danger">{{ $errors->first('newpass2') }}</p>
    @endif


  </div>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script type="text/javascript">

function removeDisable() {
    let pass = document.querySelector('#oldpass').value;
    if (typeof pass === 'string' || pass instanceof String) {
      document.querySelector('#newpass').disabled = false;
      document.querySelector('#newpass2').disabled = false;
    }

}

</script>



@endsection
