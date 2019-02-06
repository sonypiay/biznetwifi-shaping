<!DOCTYPE html>
<html lang="{{ session()->get('session_locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@lang('metaheader.description')">
  <meta name="keywords" content="@lang('metaheader.keywords')" />
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/logo_biznet_wifi.ico') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('vendor/uikit/css/uikit.min.css') }}" media="screen" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" media="screen" />
  <!-- UIkit JS -->
  <script src="{{ asset('vendor/uikit/js/uikit.min.js') }}"></script>
  <script src="{{ asset('vendor/uikit/js/uikit-icons.min.js') }}"></script>

  <!-- ionic icons -->
  <script src="https://unpkg.com/ionicons@4.5.5/dist/ionicons.js"></script>
  <title>@lang('metaheader.title')</title>
  <script type="text/javascript">
    var biznetwifi_locale = '{{ session()->get("session_locale") }}';
  </script>
</head>
<body>
@if( $request->route()->getName() !== 'pagelogin_biznetwifi' )
<script type="text/javascript">
var change_locale = {};
change_locale.change = function(lang) {
  var param = {
    method: 'post',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    url: '{{ url("/") }}/change_locale/' + lang,
    processData: true, cache: false
  };
  var d = $.ajax(param);
  d.done(function(res) {
    setTimeout(function(){
      document.location = '';
    }, 100);
  });
  d.fail(function(err) {
    console.error(err);
  });
};
</script>
<!-- nav offcanvas -->
<section id="offcanvas-mobile" uk-offcanvas="overlay: true">
  <div class="uk-offcanvas-bar offcanvas-bar">
    <div class="uk-inline">
      <!--<img class="uk-align-center logo-offcanvas" src="{{ asset('images/logo/biznetwifi_primary.png') }}" />-->
      <a class="uk-text-uppercase uk-display-block lang-offcanvas"><div class="uk-float-right">{{ session()->get('session_locale') }} <span uk-icon="chevron-down"></span></div></a>
      <div uk-dropdown="mode: click; pos: bottom" class="uk-margin-top lang-dropdown-offcanvas">
        <ul class="uk-nav uk-dropdown-nav">
          <li class="lang-sub">
            @if( session()->get('session_locale') == 'id' )
            <a class="lang-active-sub" onclick="change_locale.change('id')">ID</a>
            @else
            <a onclick="change_locale.change('id')">ID</a>
            @endif
          </li>
          <li class="lang-sub">
            @if( session()->get('session_locale') == 'en' )
            <a class="lang-active-sub" onclick="change_locale.change('en')">EN</a>
            @else
            <a onclick="change_locale.change('en')">EN</a>
            @endif
          </li>
        </ul>
      </div>
    </div>
    <ul class="uk-nav uk-nav-default uk-margin-top nav-offcanvas-bar" uk-nav>
      <li><a href="{{ route('homepage') }}">Home</a></li>
      <li><a href="#">@lang('headermenu.lokasi')</a></li>
      <li><a href="{{ route('logoutpage') }}">@lang('headermenu.logout')</a></li>
    </ul>
  </div>
</section>
<!-- nav offcanvas -->
<header class="uk-box-shadow-medium headerhmpg-cust">
  <nav class="uk-navbar navbarhmpg-cust" uk-navbar>
    <div class="uk-navbar-left">
      <a href="#" class="uk-navbar-item uk-logo">
        <img src="{{ asset('images/logo/biznetwifi_primary.png') }}" alt="biznetwifi">
      </a>
    </div>
    <div class="uk-navbar-right">
      <ul class="uk-navbar-nav uk-visible@s navhmpg-cust">
        <li><a href="{{ route('homepage') }}">Home</a></li>
        <li><a href="#">@lang('headermenu.lokasi')</a></li>
        <li><a href="{{ route('logoutpage') }}">@lang('headermenu.logout')</a></li>
        <li class="navbar-divider"></li>
        <li class="lang"><a onclick="change_locale.change('id')" @if( session()->get('sessio n_locale') == 'id' ) class="lang_active" @endif><span>ID</span></a></li>
        <li class="lang"><a onclick="change_locale.change('en')" @if( session()->get('session_locale') == 'en' ) class="lang_active" @endif><span>EN</span></a></li>
      </ul>
      <a class="uk-navbar-item uk-hidden@s naviicon_mobile" uk-toggle="target: #offcanvas-mobile">
        <span uk-icon="menu"></span>
      </a>
    </div>
  </nav>
</header>
@endif
<main id="app">
  @yield('maincontent')
</main>
@if( $request->route()->getName() != 'pagelogin_biznetwifi' )
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
@endif
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
