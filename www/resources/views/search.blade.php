@extends('layouts.app')

@section('content')


<div class="row">
  <form class="row g-3 justify-content-center" method="GET" action="{{ route('search') }}">
    <div class="col-8">
      <input type="text" class="form-control" id="search" name="search" value="{{$search}}">
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary mb-3">Search</button>
    </div>
  </form>
  <div class="col-3"></div>
  <div class="col-9">
  <div class="row">{{__('advert.searchresult')}} - {{$adverts->total()}}</div>
    @foreach($adverts as $advert)
    <div class="row g-3 align-items-center">
      <div class="col-3">
        <a href="{{ route('advert.show', [$advert]) }}"><img src="{{ url('/').'/'.$advert->photos()->first()->file }}" class="img-responsive" style="height:150px"></a>
      </div>
      <div class="col-9"> <a href="{{ route('advert.show', [$advert]) }}">{{ $advert->title }} </a></div>
    </div>
    @endforeach
  </div>

  {{ $adverts->links() }}

</div>


@endsection