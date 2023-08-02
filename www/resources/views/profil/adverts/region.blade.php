@extends('layouts.app')

@section('content')

<div class="container">

<p>{{ __('advert.region') }}</p>
<ul>
@foreach ($regions as $current)
    @if ($current->children()->count() > 0)
    <li><a href="{{ route('profil.advert.create.region', ['category' => $category, 'region' => $current]) }}">{{ $current->name }}</a></li>
    @else
    <li><a href="{{ route('profil.advert.create.content', ['category' => $category, 'region' => $current]) }}">{{ $current->name }}</a></li>
   
    @endif
    @endforeach
</ul>


<a href="{{ route('profil.advert.create.content', ['category' => $category, 'region' => $region]) }}" class="btn btn-info">{{ __('advert.curregion') }}</a>
   

</div>

@endsection


