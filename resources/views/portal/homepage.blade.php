<!doctype html>
<html lang="{{ session()->get('session_locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@lang('metaheader.description')">
  <meta name="keywords" content="@lang('metaheader.keywords')" />
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/logo_biznet_wifi.ico') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
	<script src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
	<script src="{{ asset('vendor/uikit/js/uikit-icons.min.js') }}"></script>
  <title>@lang('metaheader.title')</title>
  <script type="text/javascript">
    var biznetwifi_locale = '{{ session()->get("session_locale") }}';
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-54510905-1', 'auto');
	  ga('send', 'pageview');
  </script>
</head>
<body>
<!-- nav offcanvas -->
<section id="offcanvas-mobile" uk-offcanvas="overlay: true">
  <div class="uk-offcanvas-bar offcanvas-bar">
    <div class="uk-width-1-1 uk-inline">
      <!--<img class="uk-align-center logo-offcanvas" src="{{ asset('images/logo/biznetwifi_primary.png') }}" />-->
      <a class="uk-text-uppercase uk-display-block lang-offcanvas">{{ session()->get('session_locale') }} <span uk-icon="chevron-down"></span></a>
      <div uk-dropdown="mode: click; pos: bottom" class="uk-width-1-1 lang-dropdown-offcanvas">
        <ul class="uk-nav uk-dropdown-nav">
          <li class="lang-sub">
            @if( session()->get('session_locale') == 'id' )
            <a class="lang-active-sub" onclick="change_locale.change('id')">Indonesia</a>
            @else
            <a onclick="change_locale.change('id')">Indonesia</a>
            @endif
          </li>
          <li class="lang-sub">
            @if( session()->get('session_locale') == 'en' )
            <a class="lang-active-sub" onclick="change_locale.change('en')">English</a>
            @else
            <a onclick="change_locale.change('en')">English</a>
            @endif
          </li>
        </ul>
      </div>
    </div>
    <ul class="uk-nav uk-nav-default uk-margin-top nav-offcanvas-bar" uk-nav>
      <li><a href="{{ route('homepage') }}">Home</a></li>
      <li><a href="#">@lang('headermenu.lokasi')</a></li>
    </ul>

    <div class="uk-width-1-1 uk-inline biz-login-opt">
      <!--<img class="uk-align-center logo-offcanvas" src="{{ asset('images/logo/biznetwifi_primary.png') }}" />-->
      <a class="uk-text-uppercase uk-display-block lang-offcanvas">@lang('headermenu.login') <span uk-icon="chevron-down"></span></a>
      <div uk-dropdown="mode: click; pos: bottom" class="uk-width-1-1 lang-dropdown-offcanvas">
        <ul class="uk-nav uk-dropdown-nav">
          <li class="lang-sub"><a href="{{ route('pagelogin_member') }}">@lang('headermenu.login_opt.member')</a></li>
          <li class="lang-sub"><a href="{{ route('pagelogin_customer') }}">@lang('headermenu.login_opt.customer')</a></li>
        </ul>
      </div>
    </div>

  </div>
</section>
<!-- nav offcanvas -->

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
  <homepage url="{{ url('/') }}" :homepagelocale="{{ json_encode( __('homepage') ) }}"></homepage>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<footer class="footer">
  <div class="uk-container footer-container">
    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-expand">
        <div class="footer-info">
          <div class="footer-heading">@lang('metafooter.aboutus_heading')</div>
          <div class="footer-content"> @lang('metafooter.aboutus_content') <a href="#">@lang('metafooter.aboutus_more')</a> </div>
        </div>
        <div class="footer-info">
          <div class="footer-heading">Biznet Fiber</div>
          <div class="footer-content">
            Ajibarang | Amlapura (Karangasem) | Babat | Badung (Kuta) | Bangil | Bangli | Banjar | Banjarsari | Banyuputih | Banyuwangi | BATAM | BATAM | Batang | Bekasi | Besuki | Blitar | Blora | Bogor | Bojonegoro | Bondowoso | Boyolali | Brebes | Bumiayu | Cepu | Ciamis | Cianjur | Cibadak | Cicurug | Cikampek | Cilacap | Cimahi | Cirebon | Comal | Demak | DENPASAR | Depok | Garut | Gempol | Genteng | Gianyar | Glenmore | Gresik | Indramayu | Jajag | JAKARTA | JAMBI | Jember | Jimbaran | Jombang | Karangampel | Karawang | Kartasura | Kebumen | Kediri | Kendal | Kepanjen | Kertosono | Ketapang | Klaten | Kraksan | Krian | Kudus | Lamongan | Lawang | Lumajang | Madiun | Malang | Mojokerto | Muncar | Negara | Nganjuk | Ngawi | Ngopak | Padalarang | PADANG | Paiton | PALEMBANG | Pamanukan | Pangandaran | Pasirian | Pasuruan | Pati | Pekalongan | Pemalang | Probolinggo | Purwakarta | Purwodadi | Purwokerto | Purworejo | Rogojampi | Salatiga | SEMARANG | Semarapura (Klungkung) | SERANG | Sidoarjo | Singaraja | Situbondo | Slawi | Sleman | Solo | Sragen | Sukabumi | SURABAYA | Tabanan | Tangerang | Tangerang Selatan | Tanggul | Tasikmalaya | Tegal | Tulungagung | Turen | Ubud | Ungaran | Weleri | Wlingi | YOGYAKARTA |
          </div>
        </div>
      </div>
      <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-4@m uk-width-1-3@s">
        <ul class="uk-nav uk-nav-default link-useful">
          <li class="uk-nav-header">Useful Links</li>
          <li class="uk-nav-divider"></li>
          <li><a href="http://www.biznetnetworks.com/id/company/about-us/">@lang('metafooter.company') <span class="uk-float-right"><i class="fas fa-angle-right"></i></span> </a></li>
          <li><a href="mailto:hotspot@biznetnetworks.com">hotspot@biznetnetworks.com <span class="uk-float-right"><i class="fas fa-angle-right"></i></span> </a></li>
          <li><a href="http://www.biznetnetworks.com/id/terms-and-conditions/">@lang('metafooter.term_condition') <span class="uk-float-right"><i class="fas fa-angle-right"></i></span> </a></li>
          <li><a href="http://www.biznetnetworks.com/id/privacy-policy/">@lang('metafooter.privacy_policy') <span class="uk-float-right"><i class="fas fa-angle-right"></i></span> </a></li>
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
