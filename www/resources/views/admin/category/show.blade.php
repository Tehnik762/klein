@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('categories.show', $category) }}
@include('layouts.partials.adminnav')
<div class="container">
  <div class="row align-items-center">
    <div class="col">
    <div class="card" style="width: 30rem; margin-top: 1em;">
      <div class="card-body">
        <h5 class="card-title">{{ $category->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $category->slug }}</h6>
        <p class="card-text">
        <ul>
            <li>ID: {{ $category->id }}</li>
            
        </ul>    

        </p>
      <div class="d-flex flex-row btn-right">

        @include('layouts.partials.edithref', [
        'route' => 'categories.edit',
        'route_id' => $category->id,
        'route_name' => __('admin.edit'),
        'class' => 'secondary'
        ])

        @include('layouts.partials.edithref', [
        'route' => 'attributes.create',
        'route_id' => 'category='.$category->id,
        'route_name' => __('admin.addattr'),
        'class' => 'warning'
        ])
        
      </div>
      </div>  
    </div>
    </div>
    <div class="col">
    <div class="card" style="width: 30rem;">
      <ul class="list-group list-group-flush">
      @foreach ($attributes as $attribute)
        <li class="list-group-item btn-right">
        {{ $attribute->name }} 
        <span>
        
        @include('layouts.partials.edithref', [
        'route' => 'attributes.edit',
        'route_id' => $attribute->id,
        'route_name' => __('admin.edit'),
        'class' => 'secondary'
        ])
        @include('layouts.partials.edithref', [
        'route' => 'attributes.show',
        'route_id' => $attribute->id,
        'route_name' => __('admin.show'),
        'class' => 'info'
        ])

        <form action="{{ route('attributes.destroy', $attribute) }}" method="POST" class="del">
        @method('DELETE')
        @csrf()
        <button type="submit" class="btn btn-danger btn-sm" style="margin-top:0.5em;">
          {{ __('admin.delete') }}
        </button>
      </form>
      

        </span>
        </li>
        @endforeach
      </ul>
    </div>
    </div>
   
  </div>
</div>
 



    
   


@endsection
