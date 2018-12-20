<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
	<script src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
	<script src="{{ asset('vendor/uikit/js/uikit-icons.min.js') }}"></script>

  <title>BiznetWifi | Layanan Wi-Fi Gratis dari Biznet</title>
</head>
<body>
@include('includes.navbar-header')

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
  <homepage url="{{ url('/') }}"></homepage>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@php
  $curl = @curl_init();
  @curl_setopt_array($curl, [
    CURLOPT_URL => "http://192.168.0.45/portalhome/footerCityList",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "package=INTERNET",
    CURLOPT_HTTPHEADER => [
      "authorization: Basic Yml6bmV0cG9ydGFsOmIxem4zdDIwMThwMHJ0NGw=",
      "cache-control: no-cache",
      "content-type: application/x-www-form-urlencoded",
      "postman-token: c1412e0e-6f9d-a4c7-4c49-ca8d2346877a"
    ]
  ]);
  $response = @curl_exec( $curl );
  $cherr = curl_error( $curl );
  curl_close( $curl );
@endphp
<footer class="footer">
  <div class="uk-container footer-container">
    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-expand">
        <div class="footer-info">
          <div class="footer-heading">Tentang Biznet</div>
          <div class="footer-content">
            Biznet merupakan perusahaan yang fokus di bidang telekomunikasi dan multimedia yang memiliki komitmen untuk membangun infrastruktur modern dengan tujuan mengurangi kesenjangan digital Indonesia dengan negara berkembang lainnya.
            <a href="#">Selengkapnya</a>
          </div>
        </div>
        <div class="footer-info">
          <div class="footer-heading">Biznet Fiber</div>
          <div class="footer-content">
            @if( $cherr ) cUrl error
            @else
              @php $city = json_decode( $response ) @endphp
              {{ $city->message[0]->CityList }}
            @endif
          </div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-4@m uk-width-1-3@s">
        <ul class="uk-nav uk-nav-default link-useful">
          <li class="uk-nav-header">Useful Links</li>
          <li class="uk-nav-divider"></li>
          <li><a href="http://www.biznetnetworks.com/id/company/about-us/">Perusahaan <span class="uk-float-right"><i class="fas fa-angle-right"></i></span> </a></li>
          <li><a href="mailto:hotspot@biznetnetworks.com">hotspot@biznetnetworks.com <span class="uk-float-right"><i class="fas fa-angle-right"></i></span> </a></li>
          <li><a href="http://www.biznetnetworks.com/id/terms-and-conditions/">Syarat dan Ketentuan <span class="uk-float-right"><i class="fas fa-angle-right"></i></span> </a></li>
          <li><a href="http://www.biznetnetworks.com/id/privacy-policy/">Kebijakan Privasi <span class="uk-float-right"><i class="fas fa-angle-right"></i></span> </a></li>
        </ul>
      </div>
    </div>
    <div class="uk-margin-large-top uk-text-center midplaza">
      <div class="copyright">&copy; 2000 - {{ date('Y') }} <u>Biznet</u> All Rights Reserved. </div>
      <div class="part-midplaza">Biznet is part of <a href="https://www.midplaza.com/">Midplaza Holding</a> </div>
    </div>
    <div class="uk-margin-top uk-text-center social-media">
      <a href="https://facebook.com/BiznetHome"><span uk-icon="facebook"></span></a>
      <a href="https://facebook.com/BiznetHome" class="uk-margin-small-left"><span uk-icon="instagram"></span></a>
    </div>
  </div>
</footer>
</body>
</html>
