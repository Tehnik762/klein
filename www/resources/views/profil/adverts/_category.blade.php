<div class="offset-md-1">
<ul class="list-group list-group-flush">
    @foreach ($categories as $category)
        <li class="list-group-item"><a href="{{ route('profil.advert.create.region', $category) }}">{{ $category->name }}</a></li>
        @if ($category->children)
            @include('profil.adverts._category', ['categories' => $category->children ])
        @endif
    @endforeach
</ul>
</div>



