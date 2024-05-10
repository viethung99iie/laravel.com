    <base href="{{ config('app.url') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Dashboard v.2</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('backend/plugins/jquery-ui.css')}}" rel="stylesheet">

@if (isset($config['css']) && is_array($config['css']))
    @foreach ($config['css'] as $item )
        @if (Str::contains($item, "backend"))
            <link href="{{asset($item)}}" rel="stylesheet">
        @else
            <link href="{{$item}}" rel="stylesheet">
        @endif

    @endforeach
@endif
    <link href="{{asset('backend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/customize.css')}}" rel="stylesheet">
    <script src="{{asset('backend/js/jquery-3.1.1.min.js')}}"></script>
    <script>
        var BASE_URL = '{{config('app.url')}}/';
        var SUFFIX = '{{config('apps.general.suffix')}}';
    </script>
