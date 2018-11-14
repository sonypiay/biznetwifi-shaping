<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
<link rel="stylesheet" href="{{ asset('css/app.css') }}" media="screen" />
<script src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
<script>
  var _token = '{{ csrf_token() }}';
  var _baseurl = '{{ url('/') }}';
</script>
