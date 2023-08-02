@extends('layouts.app')

@section('content')

<div class="container">

<h2>{{__('advert.addphotos')}}</h2>

<form method="POST" action="{{ route('profil.adverts.storephotos', [$advert]) }}" enctype="multipart/form-data">
    @csrf
<div class="container">
    <div class="mb-3">
        <label for="file" class="form-label">{{ __('advert.photos') }}</label>
        <input type="file" class="form-control" id="file" placeholder="" name="file[]" required multiple />
        @if ($errors->has('file'))
        <p class="text-danger">{{ $errors->first('file') }}</p>
        @endif
    </div>

</div>

<button type="submit" class="form-control btn btn-warning" style="margin-top: 1em;">{{ __('advert.addphotos') }}</button>
</form>


</div>
@endsection


