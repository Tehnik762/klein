<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.index') }}">{{ __('admin.dashboard') }}</a>
  </li>
 <li class="nav-item">
    <a class="nav-link{{isset($users_active)? " active" : ""}}" href="{{ route('users.index') }}">{{ __('admin.users') }}</a>
  </li>

  <li class="nav-item">
    <a class="nav-link{{isset($regions_active)? " active" : ""}}" href="{{ route('regions.index') }}">{{ __('admin.regions') }}</a>
  </li>

  <li class="nav-item">
    <a class="nav-link{{isset($categories_active)? " active" : ""}}" href="{{ route('categories.index') }}">{{ __('admin.category') }}</a>
  </li>

  <li class="nav-item">
    <a class="nav-link{{isset($manage_active)? " active" : ""}}" href="{{ route('manage.index') }}">{{ __('admin.manage') }}</a>
  </li>
 <!-- <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled">Disabled</a>
  </li>-->
</ul>