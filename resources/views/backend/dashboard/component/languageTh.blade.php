@foreach($language as $val)
@if(config('app.locale') === $val->canonical)

@continue
@endif
<th class="text-center"><span class="image img-scaledown laguange-flag"><img src="{{ $val->image }}" alt=""></span></th>

@endforeach
