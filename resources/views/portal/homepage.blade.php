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
  <link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
	<script src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
	<script src="{{ asset('vendor/uikit/js/uikit-icons.min.js') }}"></script>
  <title>@lang('metaheader.title')</title>
  <script type="text/javascript">
    var biznetwifi_locale = '{{ session()->get("session_locale") }}';
  </script>
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
            Ajibarang | Amlapura (Karangasem) | Babat | Badung (Kuta) | BANDUNG | Bangil | Bangli | Banyuwangi | Batam | Batang | Bekasi | Besuki | Blitar | Blora | Bogor | Bojonegoro | Bondowoso | Boyolali | Brebes | Bumiayu | Cepu | Cianjur | Cibadak | Cicurug | Cikampek | Cimahi | Cirebon | Comal | Demak | DENPASAR | Depok | Gempol | Genteng | Gianyar | Glenmore | Gresik | Indramayu | Jajag | JAKARTA | JAMBI | Jember | Jimbaran | Jombang | Karangampel | Karawang | Kartasura | Kebumen | Kediri | Kendal | Kepanjen | Kertosono | Klaten | Kraksan | Krian | Kudus | Lamongan | Lawang | Lumajang | Madiun | Malang | Mojokerto | Muncar | Negara | Nganjuk | Ngawi | Ngopak | Padalarang | PADANG | Paiton | PALEMBANG | Pamanukan | Pasirian | Pasuruan | Pati | Pekalongan | Pemalang | Probolinggo | Purwakarta | Purwodadi | Purwokerto | Purworejo | Rogojampi | Salatiga | SEMARANG | Semarapura (Klungkung) | SERANG | Sidoarjo | Situbondo | Slawi | Sleman | Solo | Sragen | Sukabumi | SURABAYA | Tabanan | Tangerang | Tangerang Selatan | Tanggul | Tegal | Tulungagung | Turen | Ubud | Ungaran | Weleri | Wlingi | YOGYAKARTA
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
