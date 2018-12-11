<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
  <link rel="stylesheet" href="{{ asset('css/connect.css') }}" />
  <!-- UIkit JS -->
	<script src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
	<script src="{{ asset('vendor/uikit/js/uikit-icons.min.js') }}"></script>
  <!--<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>-->

  <title>BiznetWifi | Connect to Wifi</title>
</head>
<body>
<div id="app">
  <connect-section url="{{ url('/') }}"
  client_mac="{{ $mac }}"
  uip="{{ $uip }}"
  ssid="{{ $ssid }}"
  starturl="http://qabiznethotspot.qeon.co.id"
  :loc="{{ json_encode( $loc ) }}"
  ap="{{ $ap }}"></connect-section>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
