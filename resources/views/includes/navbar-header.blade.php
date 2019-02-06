<!--<nav class="uk-navbar uk-box-shadow-medium navbarlang" uk-navbar>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      <li class="lang"><a @if( session()->get('session_locale') == 'id' ) class="lang_active" @endif href="#"><span>ID</span></a></li>
      <li class="lang"><a @if( session()->get('session_locale') == 'en' ) class="lang_active" @endif href="#"><span>EN</span></a></li>
    </ul>
  </div>
</nav>-->
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
<nav class="uk-navbar uk-box-shadow-medium navbar" uk-navbar>
   <div class="uk-navbar-left">
     <a class="uk-navbar-item uk-logo" href="#">
       <img class="logo-nav" src="{{ asset('images/logo/biznetwifi_primary.png') }}" />
     </a>
   </div>
   <div class="uk-navbar-right">
     <ul class="uk-navbar-nav uk-visible@s">
       <li><a href="{{ route('homepage') }}">Home</a></li>
       <li><a href="#">@lang('headermenu.lokasi')</a></li>
       <li><a href="{{ route('pagelogin_biznetwifi') }}">@lang('headermenu.login')</a></li>
       <li class="navbar-divider"></li>
       <li class="lang"><a onclick="change_locale.change('id')" @if( session()->get('session_locale') == 'id' ) class="lang_active" @endif><span>ID</span></a></li>
       <li class="lang"><a onclick="change_locale.change('en')" @if( session()->get('session_locale') == 'en' ) class="lang_active" @endif><span>EN</span></a></li>
     </ul>
     <a class="uk-navbar-item uk-hidden@s naviicon_mobile" uk-toggle="target: #offcanvas-mobile">
       <span uk-icon="menu"></span>
     </a>
   </div>
 </nav>
