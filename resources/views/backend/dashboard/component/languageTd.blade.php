@foreach($language as $val)

@if(config('app.locale') === $val->canonical)

@continue
@endif
<td class="text-center">

    @php
    $translated = $model->languages->contains('id', $val->id);
    @endphp
    <a class="{{ ($translated) ? '' : 'text-danger' }}" href="{{ route('language.translate', ['postId' => $model->id, 'languageId' => $val->id, 'model' => $modeling]) }}">{{ ($translated) ? 'Đã dịch'  : 'Chưa dịch' }}</a>


</td>
@endforeach

