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
<header class="uk-box-shadow-medium uk-visible@s headerhmpg-cust">
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

<header class="uk-hidden@s uk-box-shadow-medium headermobile-customer">
  <nav class="uk-navbar navbarmobile-cust" uk-navbar>
    <div class="uk-navbar-left">
      <a href="#" class="uk-navbar-item uk-logo">
        <img src="{{ asset('images/logo/biznetwifi_white.png') }}" alt="biznetwifi">
      </a>
    </div>
    <div class="uk-navbar-right">
      <a class="uk-navbar-item naviicon_mobile" uk-toggle="target: #offcanvas-mobile">
        <span uk-icon="menu"></span>
        <!--<span class="icon ion-ios-menu"></span>-->
      </a>
    </div>
  </nav>
</header>
