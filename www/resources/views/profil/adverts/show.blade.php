@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('profil.adverts.show', $advert) }}
<div class="container">
<div class="row">

<div class="col">
<h2>{{__('advert.show')}}</h2>
</div>
<div class="col">
    @if ($advert->isDraft())
<a href="{{ route('profil.moderate', [$advert]) }}" class="btn btn-secondary btn-sm float-start">{{__('advert.moderationaction')}}</a>
    @elseif ($advert->isOnModeration())
    <p>{{ __('advert.sentmoderate') }}</p>
    @endif
    @if ($advert->isActive())
    <a href="{{ route('profil.deactivate', [$advert]) }}" class="btn btn-secondary btn-sm float-start">{{__('advert.deactivate')}}</a>
    @endif
<form method="post" action="{{ route('profil.delete', [$advert]) }}">
    @csrf
    <button type="submit" name="delete" class="btn btn-sm btn-warning float-end">{{__('admin.delete')}}</button>
</form>

</div>

<div class="row">

<div class="col">
    <div class="card card-advert">
        <div class="card-body">
            <h5 class="card-title">{{ $advert->title }} 
            </h5>
            <p class="card-text">
            <ul>
                <li>{{ __('advert.status') }} : {{ $status_list[$advert->status] }}</li>
                <li>{{ __('advert.address') }}: {{ $advert->address }}</li>
                <li>{{ __('advert.price') }}: {{ $advert->price }}</li>
            </ul>
            </p>
            <a href="{{ route('profil.info.edit', [$advert]) }}" class="btn btn-primary">{{__('admin.edit')}}</a>
        </div>
    </div>
</div>

<div class="col">
@isset($advert->reject_reason)
<div class="card card-advert">
<div class="card-body">
{{ __('advert.rejectreason') }} - <code>{{$advert->reject_reason}}</code>
</div></div>
@endisset

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
                    <li>{{$attributes[$attr->attribute_id]->name}}: {{ $attr->value }}</li>
                    @endforeach
                </ul>
            </p>
            <a href="{{ route('profil.attributes', [$advert]) }}" class="btn btn-primary">{{__('admin.edit')}}</a>
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
                        @include ('layouts.partials.deletephoto', ['destination' => 'profil.deletephoto', 'id' => $photo->id])  
                        <a href="/{{ $photo->file }}" data-fslightbox >  
                        <img src="/{{ $photo->file }}" class="img-fluid-admin" />
                        </a>
                    </li>
                @endforeach
            </ul>
            </p> 
            <a href="{{ route('profil.adverts.addphotos', [$advert]) }}" class="btn btn-secondary">{{__('admin.add')}}</a>
        </div>
    </div>
</div>
</div>
</div>
@endsection


