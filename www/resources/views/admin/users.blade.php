@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('users.index') }}
@include('layouts.partials.adminnav')

<div class="container text-center">

<form method="get" action="?" id="filter">
<div class="row justify-content-center py-3">
    <div class="col-3">
    <input type="text" class="form-control" placeholder="Name" id="name" aria-describedby="name" name="name" value="{{ request('name') }}">
    </div>
    <div class="col-3">
    <input type="text" class="form-control" placeholder="Email" id="email" aria-describedby="email" name="email" value="{{ request('email') }}">
    </div>
    <div class="col-2">
    <select name="role" class="form-select">
    <option value="">Role</option>
      @foreach ($roles as $key=>$value)
        <option value="{{ $key }}" {{ intval(request('role')) === $key?'selected' : '' }}>{{ $value }}</option>
      @endforeach
    </select>
    </div>
    <div class="col-2">
    <select name="status" class="form-select">
      <option value="">Status</option>
      @foreach ($statuses as $key=>$value)
       {{ $k = intval($key); }}
        <option value="{{ $key }}" {{ intval(request('status')) === $key?'selected' : '' }}>{{ $value }}</option>
      @endforeach
    </select>
    </div>
    <div class="col-1">
    <button type="submit" class="btn btn-primary">GO!</button>
    </div>

  </div>
</div>
</form>

<table class="table table-striped table-hover">

    <thead>
        <tr>
        <th scope="col">{{ __('admin.id') }}</th>
        <th scope="col">{{ __('admin.name') }}</th>
        <th scope="col">{{ __('admin.edit') }}</th>
        <th scope="col">{{ __('admin.email') }}</th>
        <th scope="col">{{ __('admin.status') }}</th>
        <th scope="col">{{ __('admin.role') }}</th>  
      </tr>
     </thead>
     <tbody class="table-group-divider">
@foreach ($users as $user)
    <tr>
      <th scope="row">{{ $user->id }}</th>
      <td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a> 
      @if ($user->isPhoneVerified())
        <i>{{__('phone_verified')}}</i>
      @endif
      </td>
      <td>
      @include('layouts.partials.edithref', [
        'route' => 'users.edit',
        'route_id' => $user->id,
        'route_name' => __('admin.edit'),
        'class' => 'indo'
        ])
      </td>
      <td>{{ $user->email }}</td>
      <td>
        @if ($user->status == \App\Models\User::STATUS_ACTIVE)
        <span class="badge rounded-pill text-bg-success">Active</span>
        @endif
        @if ($user->status == \App\Models\User::STATUS_WAIT)
        <span class="badge rounded-pill text-bg-primary">Waiting</span>
        @endif
      </td>
      <td>
        @if ($user->isAdmin())
        <span class="badge rounded-pill text-bg-success">Admin</span>
        @elseif ($user->isUser())
        <span class="badge rounded-pill text-bg-primary">User</span>
        @endif
      </td>
    </tr>
@endforeach
     </tbody>



</table>



{{ $users->onEachSide(5)->links() }}



@endsection
