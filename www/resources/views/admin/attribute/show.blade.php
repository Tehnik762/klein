@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('attributes.show', $category, $attribute) }}
@include('layouts.partials.adminnav')
<div class="container">
  <div class="row align-items-center">
    <div class="col">
    <div class="card" style="width: 18rem; margin-top: 1em;">
      <div class="card-body">
        <h5 class="card-title">{{ $attribute->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted"></h6>
        <p class="card-text">
        <ul>
            <li>{{ __('admin.type') }} - {{ $attribute->type }}</li>           
        </ul>    

        </p>
      <div class="d-flex flex-row">
       
        
      </div>
      </div>  
    </div>
    </div>
    <div class="col">
      @if ($attribute->isSelect())
    <a class="btn btn-secondary" data-bs-toggle="collapse" href="#variants" role="button" aria-expanded="false" aria-controls="collapseExample">
    {{ __('admin.variants') }}
    </a>
    
    <div class="collapse" id="variants">
    <div class="card" style="width: 18rem;">
     
    <ul class="list-group list-group-flush">
      @foreach ($attribute->variants as $variant)
        <li class="list-group-item btn-right">
          {{ $variant }}
        </li>
        @endforeach
      </ul>
    </div>
    </div>
    @endif
  </div>
   
  </div>
</div>
 



    
   


@endsection
