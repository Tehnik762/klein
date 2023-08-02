@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('users.show', $user) }}
@include('layouts.partials.adminnav')

    <div class="card" style="width: 18rem; margin-top: 1em;">
      <div class="card-body">
        <h5 class="card-title">{{ $user->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $user->email }}</h6>
        <p class="card-text">
        <ul>
            <li>ID: {{ $user->id }}</li>
            <li>Status: 
                @if ($user->isActive())
                <span class="badge rounded-pill text-bg-success">Active</span>
                @endif
                @if ($user->isWait())
                <span class="badge rounded-pill text-bg-primary">Waiting</span>
                @endif
            </li>
            @if ($user->isPhoneVerified())
            <li>
              
           
                {{__('admin.phone')}} : {{ $user->phone }}
                @elseif ($user->phone)
                <span class="badge rounded-pill text-bg-warning">{{__('admin.phone_not_verified')}}</span>
               
            </li>
            @endif
            <li>
              Role:
              @if ($user->isAdmin())
                <span class="badge rounded-pill text-bg-info">Admin</span>
                @elseif ($user->isUser())
                <span class="badge rounded-pill text-bg-secondary">User</span>
                @endif
            </li>
        </ul>    

        </p>
      <div class="d-flex flex-row">
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-secondary">
        
            {{ __('admin.edit') }}
         
        </a>
        @if ($user->isWait())
        <form action="{{ route('users.activate', $user->id) }}" method="POST" style="margin-left: 0.5em">
        @csrf()
        <button type="submit" class="btn btn-info">
          {{ __('admin.activate') }}
        </button>
        </form>
        @endif
        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="margin-left: 0.5em">
        @method('DELETE')
        @csrf()
        <button type="submit" class="btn btn-danger">
          {{ __('admin.delete') }}
        </button>
      </form>
      </div>
      </div>  
    </div>


@endsection
