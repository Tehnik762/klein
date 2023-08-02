@extends('layouts.app')

@section('content')
<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link active" href="{{ route('admin.index') }}">{{ __('admin.dashboard') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('users.index') }}">{{ __('admin.users') }}</a>
  </li> 
  <li class="nav-item">
    <a class="nav-link" href="{{ route('regions.index') }}">{{ __('admin.regions') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('categories.index') }}">{{ __('admin.category') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('manage.index') }}">{{ __('admin.manage') }}</a>
  </li>



@endsection
