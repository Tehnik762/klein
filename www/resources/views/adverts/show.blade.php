@extends('layouts.app')

@section('content')

@include('layouts.partials.adminnav')

<div class="container">

{{ Breadcrumbs::render('adverts.show', $advert) }}

<div class="row">
    <div class="col">
        <h2>{{__('advert.show')}}</h2>
    </div>
    <div class="col">
    <div class="col">
        @if ($advert->isOnModeration())
        <a href="{{ route('manage.approve', [$advert]) }}" class="btn btn-info">{{__('admin.approve')}}</a>
        <a id="butreject" class="btn btn-secondary float-end">{{__('admin.reject')}}</a>
        @endif

        @if ($advert->isActive())
             <a href="{{ route('manage.deactivate', [$advert]) }}" class="btn btn-secondary btn-sm float-start">{{__('advert.deactivate')}}</a>
         @endif
        <form method="post" action="{{ route('manage.delete', [$advert]) }}">
            @csrf
            <button type="submit" name="delete" class="btn btn-sm btn-warning float-end">{{__('admin.delete')}}</button>
        </form>



    </div>
    </div>
</div>


<div class="row">

<div class="col">
    <div class="card card-advert">
        <div class="card-body">
            <h5 class="card-title">{{ $advert->title }}</h5>
            <p class="card-text">
            <ul>
                <li>{{ __('advert.status') }} : {{ $statuses[$advert->status] }}</li>
                <li>{{ __('advert.address') }}: {{ $advert->address }}</li>
                <li>{{ __('advert.price') }}: {{ $advert->price }}</li>
            </ul>
            </p>
            <a href="{{ route('manage.info.admin', [$advert]) }}" class="btn btn-primary">{{__('admin.edit')}}</a>
        </div>
    </div>
</div>

<div class="col">
<div class="card card-advert">
    <div class="card-body">
        <h5 class="card-title">{{ __('advert.content') }}</h5>
        <p class="card-text">
        {!! nl2br(e($advert->content)) !!}
        </p>

    </div>
</div>


</div>

</div>
<div class="row">
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
            <a href="{{ route('manage.attributes.admin', [$advert]) }}" class="btn btn-primary">{{__('admin.edit')}}</a>
        </div>
    </div>

       
       
    </div>
<div class="col">
    <div class="card card-advert">
        <div class="card-body">
            <h5 class="card-title"> {{ __('advert.photos') }}</h5>
            <p class="card-text">
                <ul class="list-group">
            @foreach ($advert->photos as $photo)
<li class="list-group-item">
	        @include ('layouts.partials.deletephoto', ['destination' => 'manage.deletephoto', 'id' => $photo->id])  
            <a href="/{{ $photo->file }}" data-fslightbox >  
            <img src="/{{ $photo->file }}" class="img-fluid-admin" />
            </a>
</li>
            @endforeach
                </ul>
            </p> 
            </div>
    </div>
</div>
</div>
</div>

<div class="container" style="padding-top: 2rem;">
<form id="reason_form" action="{{route('manage.reject', [$advert])}}"  style="display:none;" class="row gx-5 align-items-center">

<div class="col-sm-7">
    <input type="text" class="form-control" id="reason" name="reason" placeholder="{{__('admin.reasontype')}}">
</div>
<div class="col">
<button type="submit" class="btn btn-primary">{{__('admin.reject')}}</button>
</div>
</form>
</div>




<script>
var button = document.getElementById("butreject");
var reasonForm = document.getElementById("reason_form");
button.addEventListener("click", function() {
  reasonForm.style.display = "flex";
  reasonForm.scrollIntoView({ behavior: "smooth" });
});

    </script>

@endsection


