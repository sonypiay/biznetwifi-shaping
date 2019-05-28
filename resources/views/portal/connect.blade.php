<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@lang('metaheader.description')">
  <meta name="keywords" content="@lang('metaheader.keywords')" />
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/logo_biznet_wifi.ico') }}">
  <link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
  <link rel="stylesheet" href="{{ asset('css/connect.css') }}" />
	<script src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
	<script src="{{ asset('vendor/uikit/js/uikit-icons.min.js') }}"></script>
  <script>
  	 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','http://biznethotspot.qeon.co.id/js/analytic/biznet-analytics.js','ga');

  	  ga('create', 'UA-54510905-1', 'auto');
  	  ga('send', 'pageview');
  </script>
  <title>BiznetWifi | Connect to Wifi</title>
  <script type="text/javascript">
    var biznetwifi_locale = '{{ session()->get("session_locale") }}';
  </script>
</head>
<body>
<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 946017023;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/946017023/?guid=ON&amp;script=0"/>
</div>
</noscript>

<div id="app">
  <connect-section url="{{ url('/') }}"
  client_mac="{{ $mac }}"
  uip="{{ $uip }}"
  ssid="{{ $ssid }}"
  starturl="http://www.biznethotspot.com/afterlogin"
  :loc="{{ json_encode( $loc ) }}"
  ap="{{ $ap }}"
  shaping="{{ $shaping }}"
  :connectlocale="{{ json_encode( __('connect') ) }}"
  :homepagelocale="{{ json_encode( __('homepage') ) }}"></connect-section>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
