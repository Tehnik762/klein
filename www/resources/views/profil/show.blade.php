@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('profil.personal') }}


    <div class="card" style="width: 18rem; margin-top: 1em;">
      <div class="card-body">
        <h5 class="card-title">{{ $user->email }}</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <p class="card-text">
        {{ __('admin.lastname') }} :  {{ $user->lastname }} <br>
        {{ __('admin.name') }} :  {{ $user->name }}<br>
        @if ($user->isPhoneVerified())
        {{ __('admin.phone') }} : {{ $user->phone }}
        
        
        <form method="POST" action="{{ route('profil.personal.phoneauth') }}">
          @csrf
          @if (!$user->isPhoneAuthActivated())
            <button type="submit" class="btn btn-secondary btn-sm">{{__('admin.activatetwo')}}</button>
          @else 
           <button type="submit" class="btn btn-warning btn-sm">{{__('admin.disabletwo')}}</button>
          @endif
        </form>
       

        @elseif ($user->phone)
        <form method="POST" action="{{ route('profil.personal.verify') }}">
          @csrf
            <button type="submit" class="btn btn-primary btn-sm">{{__('admin.verify')}}</button>

        </form>
        
        @endif


        </p>

        <a href="{{ route('profil.personal.edit') }}">
        <button class="btn btn-primary">
          
          {{ __('navigation.edit') }}
          
        </button>
        </a>
     
      </div>  
    </div>


@endsection
