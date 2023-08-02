<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

    
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])


    </head>
    <body class="antialiased">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-success shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                @include('layouts.partials.language')
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profil.home') }}">{{__('navigation.profil')}}</a>
                            </li>
                            
                            @can('admin-panel')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.index') }}">{{__('navigation.admin')}}</a>
                            </li>
                            @endcan
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        </header>

    
        <div class="album py-5 bg-light">
            <div class="container">
                <form class="row g-3 justify-content-center" method="GET" action="{{ route('search') }}">
                     <div class="col-8">
                       <input type="text" class="form-control" id="search" name="search">
                       <input type="hidden" value="1" name="status">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Search</button>
                    </div>
                </form>

            <div class="row">
                <div class="col-3">
                    <div class="sticky-top" style="padding-top: 10px;">
                    <div class="card shadow-sm">
                    @isset($categories)
                    <h2 class="text-center" style="padding-top:5px">{{ isset($category) ? $category->name : __('advert.categories') }}</h2>

                        @foreach($categories as $cat)

                            <a href="{{ route('index.filtered', adverts_path($region, $cat)) }}" class="btn btn-primary btn-sm category-menu">{{ $cat->name }}</a>

                        @endforeach
                    @endisset
                    @isset($regions)
                    <h2 class="text-center" style="padding-top:5px">
                        @if (isset($region) and $region != 'all')
                        {{ $region->name }}
                        @else
                        {{ __('advert.regions') }}
                        @endif
                    </h2>
                        @foreach($regions as $reg)
                            <a href="{{ route('index.filtered', adverts_path($reg, $category)) }}" class="btn btn-info  btn-sm category-menu">{{ $reg->name }}</a>

                        @endforeach
                    @endisset
                    </div>

                    </div>
                </div>
                <div class="col-9">
                @isset($adverts_path)
                {{ Breadcrumbs::render('list', $adverts_path) }}
                @endisset

                @foreach ($adverts as $advert)
                @if ($loop->index % 3 == 0 )
                    @if (!$loop->first)
                    </div>
                    @endif
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @endif
                
                    <div class="col">
                        <div class="card shadow-sm">
                            <img src="{{ url('/').'/'.$advert->photos()->first()->file }}" class="img-responsive">
                            <div class="card-body">
                                <p class="card-text">
                                    <div class="text-truncate">
                                    {{ $advert->title }}
                                    </div>
                                    <span>{{__('advert.cat') }} - <span class="badge text-bg-danger">{{ $advert->category->name }}</span></span>
                                    <div class="text-end">
                                    <span class="badge text-bg-warning price">{{ number_format($advert->price, 0, '.', ' ') }}</span></div>
                                </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-primary float-end" href="{{ route('advert.show', [$advert]) }}">{{ __('admin.show') }}</a>
                                        </div>
                                        <small class="text-muted">{{ $advert->published_at->format("d.m.y") }}</small>
                                    </div>
                            </div>
                        </div>
                    </div>
        

                @if ($loop->last)
                    </div>
                @endif

                @endforeach
                {{ $adverts->links() }}
                </div>
            </div>

            </div>
            
   

    
    
<footer class="text-muted py-5">
  <div class="container">
    <p class="float-end mb-1">
      <a href="#">{{__('main.back')}}</a>
    </p>
    <p class="mb-1">{{__('main.footer')}}</p>
    </div>
</footer>
    
    
    
            </body>
</html>
