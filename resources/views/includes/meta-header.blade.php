<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="Biznet Wifi adalah Layanan Wi-Fi Turbo 100 Mbps GRATIS untuk pelanggan Biznet Home dan Biznet Metronet.">
<meta name="keywords" content="Biznet, 5G, WiFi, Wi-Fi, cepat, murah, hotspot, internet" />
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/logo_biznet_wifi.ico') }}">
<link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
<link rel="stylesheet" href="{{ asset('css/app.css') }}" media="screen" />
<script src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
<script>
  var _token = '{{ csrf_token() }}';
  var _baseurl = '{{ url('/') }}';
</script>
