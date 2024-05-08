<!-- Mainly scripts -->
    <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('backend/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('backend/library/library.js')}}"></script>
<!-- Custom and plugin javascript -->
    <script src="{{asset('backend/js/inspinia.js')}}"></script>
    <script src="{{asset('backend/js/plugins/pace/pace.min.js')}}"></script>
    <script src="{{asset('backend/plugins/jquery-ui.js')}}"></script>

 @if (isset($config['js']) && is_array($config['js']))
    @foreach ($config['js'] as $item )
        @if (Str::contains($item, "backend"))
            <script src="{{asset($item)}}"></script>
        @else
            <script src="{{$item}}"></script>
        @endif
    @endforeach
 @endif
