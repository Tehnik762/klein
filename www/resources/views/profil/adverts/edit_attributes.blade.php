@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('profil.edit_attr', $advert) }}



<h3>{{ __('admin.edit') }} - {{ $advert->title }}</h3>
<form method="POST" action="{{ route('profil.update.attributes', $advert) }}">
    @csrf
    @method('PUT')
  @foreach ($advert->values as $value)
    <label>{{ $attributes[$value->attribute_id]->name }}</label>
    @if ($attributes[$value->attribute_id]->isSelect())
    <select name="attributes[{{$value->attribute_id}}]"  class="form-select">
      @foreach ($attributes[$value->attribute_id]->variants as $variant)
        <option value="{{$variant}}"{{ $variant == $value->value? " selected":""}}>{{ $variant }}</option>
      @endforeach
    </select>
    @elseif ($attributes[$value->attribute_id]->isNumber())
    <input class="form-control" type="number" 
    name="attributes[{{$value->attribute_id}}]" id="attribute_{{ $value->attribute_id }}" 
    value="{{ $value->value ?? old('attribute.'.$value->attribute_id)}}"/>
    @else
    <input class="form-control" type="text" 
    name="attributes[{{$value->attribute_id}}]" id="attribute_{{ $value->attribute_id }}" 
    value="{{ $value->value ?? old('attribute.'.$value->attribute_id)}}"/>
    @endif
    
    @if ($errors->has('attributes[$value->attribute_id]'))
      <p class="text-danger">{{ $errors->first('attributes[$value->attribute_id]') }}</p>
    @endif

  @endforeach
@foreach ($errors->all() as $error)
{{ $error }}
@endforeach

  <button type="submit" class="btn btn-primary">Submit</button>
</form>




@endsection
