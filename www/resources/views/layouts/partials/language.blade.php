@if (getLocale() == "de")
<a href="{{ route('locale', ['locale' => 'en']) }}"><img src="/storage/assets/en.png"/></a>
@else
<img class="opacity-50" src="/storage/assets/en.png"/>
@endif
@if (getLocale() == "en") 
 <a href="{{ route('locale', ['locale' => 'de']) }}"><img src="/storage/assets/de.png"/></a>
@else
 <img class="opacity-50" src="/storage/assets/de.png"/>
@endif