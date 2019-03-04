<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('administrator.includes.meta-header')
<title>BiznetWifi @yield('tag_admin_title')</title>
</head>
<body>
<div class="uk-grid-collapse" uk-grid>
  <section class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@m uk-width-1-1@s">
    @include('administrator.includes.navbarleft')
  </section>
  <section class="uk-width-expand">
    <header class="uk-navbar headertop" uk-navbar>
      <div class="uk-navbar-right">
        <ul class="uk-navbar-nav navbartop">
          <li><a href="#">Hi, Administrator</a></li>
        </ul>
      </div>
    </header>
    <div id="app">@yield('main_section')</div>
    <script type="text/javascript" src="{{ asset('js/admin/app.administrator.js') }}"></script>
  </section>
</div>
</body>
</html>
