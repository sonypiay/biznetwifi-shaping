<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="Biznet Wifi adalah Layanan Wi-Fi Turbo 100 Mbps GRATIS untuk pelanggan Biznet Home dan Biznet Metronet.">
<meta name="keywords" content="Biznet, 5G, WiFi, Wi-Fi, cepat, murah, hotspot, internet" />
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/logo_biznet_wifi.ico') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
<link rel="stylesheet" href="{{ asset('css/app.css') }}" media="screen" />
<script src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
<script>
  var _token = '{{ csrf_token() }}';
  var _baseurl = '{{ url('/') }}';

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-54510905-1', 'auto');
	  ga('send', 'pageview');
</script>
