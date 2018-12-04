<nav class="uk-navbar uk-box-shadow-medium navbar" uk-navbar>
   <div class="uk-navbar-left">
     <a class="uk-navbar-item uk-logo" href="#">
       <img class="logo-nav" src="{{ asset('images/logo/biznetwifi_primary.png') }}" />
     </a>
   </div>
   <div class="uk-navbar-right">
     <ul class="uk-navbar-nav uk-visible@s">
       <li><a href="{{ route('homepage') }}">Home</a></li>
       <li><a href="#">Lokasi BiznetWifi</a></li>
     </ul>
     <a class="uk-navbar-item uk-hidden@s naviicon_mobile" href="#">
       <span uk-icon="menu"></span>
     </a>
   </div>
 </nav>
