<form method="post" action="{{ route('advert.fav', $advert)}}">
  @csrf
<button class="btn btn-warning">
{{__('advert.unmakefav')}}
</button>
</form>