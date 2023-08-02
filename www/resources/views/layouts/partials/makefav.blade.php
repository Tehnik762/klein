<form method="post" action="{{ route('advert.fav', $advert)}}">
  @csrf
<button class="btn btn-primary">
{{__('advert.makefav')}}
</button>
</form>