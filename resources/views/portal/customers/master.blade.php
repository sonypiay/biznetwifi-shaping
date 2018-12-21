<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="Biznet Wifi adalah Layanan Wi-Fi Turbo 100 Mbps GRATIS untuk pelanggan Biznet Home dan Biznet Metronet.">
  <meta name="keywords" content="Biznet, 5G, WiFi, Wi-Fi, cepat, murah, hotspot, internet" />
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/logo_biznet_wifi.ico') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
<link rel="stylesheet" href="{{ asset('css/app.css') }}" media="screen" />
<!-- UIkit JS -->
<script src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
<script src="{{ asset('vendor/uikit/js/uikit-icons.min.js') }}"></script>
<title>BiznetWifi - Wi-Fi Turbo Gratis untuk pelanggan Biznet</title>
</head>
<body>
@if( $request->route()->getName() !== 'pagelogin_biznetwifi' )
<header class="uk-box-shadow-medium headerhmpg-cust">
  <nav class="uk-navbar navbarhmpg-cust" uk-navbar>
    <div class="uk-navbar-left">
      <a href="#" class="uk-navbar-item uk-logo">
        <img src="{{ asset('images/logo/biznetwifi_primary.png') }}" alt="biznetwifi">
      </a>
    </div>
    <div class="uk-navbar-right">
      <ul class="uk-navbar-nav navhmpg-cust">
        <li><a href="{{ route('logoutpage') }}">Log out</a></li>
        <!--<li><a href="#">Home</a></li>
        <li><a href="#">Tentang Biznet</a></li>
        <li><a href="#">Lokasi</a></li>
        <li><a href="#">John Doe</a></li>-->
      </ul>
    </div>
  </nav>
</header>
@endif
<main id="app">
  @yield('maincontent')
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
</main>
@if( $request->route()->getName() != 'pagelogin_biznetwifi' )
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
@endif
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
