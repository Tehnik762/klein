@extends('layouts.app')

@section('content')


<div class="container">

{{ Breadcrumbs::render('list.show', $advert) }}
              
<div class="row align-items-center">

<div class="col">
<h1 class="card-title">{{ $advert->title }}</h1>
</div>
<div class="col text-end">
    @isset($user)
        @if ($advert->isFavourite($user))
            @include('layouts.partials.unmakefav', ['advert' => $advert])
        @else
            @include('layouts.partials.makefav', ['advert' => $advert])
        @endif
    @endif

    {{ __('advert.addfavourite') }} - {{ $advert->countFavourite() }}
</div>
</div>

<div class="row">

<div class="col">
    <div class="card card-advert">
        <div class="card-body">
           
            <p class="card-text">
            <ul>
                <li>{{ __('advert.address') }}: {{ $advert->address }}</li>
                <li>{{ __('advert.price') }}: {{ number_format($advert->price, 0, '.', ' ')  }}</li>
            </ul>
            </p>
        </div>
    </div>
</div>

<div class="col">
<div class="card card-advert" style="height: 100%;">
    <div class="card-body">
        <p class="card-text">
        {!! nl2br(e($advert->content)) !!}
        </p>

    </div>
</div>


</div>

</div>
<div class="row">
    @if (count($advert->values) > 0)
    <div class="col">
    <div class="card card-advert">
        <div class="card-body">
            <h5 class="card-title"> {{ __('advert.attributes') }}</h5>
            <p class="card-text">
                <ul>
                    @foreach ($advert->values as $attr)
                    @if ($attributes[$attr->attribute_id]->isSelect())
                    <li>{{$attributes[$attr->attribute_id]->name}}: {{ $attr->value }}</li>
                    @else
                    <li>{{$attributes[$attr->attribute_id]->name}}: {{ $attr->value }}</li>
                    @endif
                    @endforeach
                </ul>

            </p>
        </div>
    </div>

    </div>
    @endif
<div class="col">
    <div>
        <div class="card-body">
            <h5> {{ __('advert.photos') }}</h5>
            <p class="card-text">
                
            @foreach ($advert->photos as $photo)
                
                            <a href="/{{ $photo->file }}" data-fslightbox >  
                            <img src="/{{ $photo->file }}" class="img-fluid-front img-thumbnail" />
                            </a>
             
            @endforeach
                
            </p> 
            </div>
    </div>
</div>
</div>

<div class="row mt-5">
    <div id="map" style="height: 500px;"></div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>


<script>

    document.addEventListener('DOMContentLoaded', function() {
  
    var map = L.map('map').setView([51.1638175, 10.4478313], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);
    var address = "{{ $advert->address }}";
    
    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address))
        .then(function(response) {
            return response.json();
        })
        .then(function(json) {
            if (json.length > 0) {
                var obj = json[0];

                // Создание маркера с координатами объекта и добавление на карту
                L.marker([obj.lat, obj.lon]).addTo(map)
                    .bindPopup(address)
                    .openPopup();

                // Перемещение центра карты на координаты объекта
                map.setView([obj.lat, obj.lon], 13);
            }
        });

});

</script>
@endsection

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
@endsection
