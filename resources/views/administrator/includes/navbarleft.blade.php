<nav class="uk-card uk-card-default uk-card-body uk-card-small navbarleft" uk-height-viewport>
  <div class="uk-text-center">
    <img class="navbarlogo" src="{{ asset('images/logo/biznetwifi_primary.png') }}" alt="{{ asset('images/logo/biznetwifi_primary.png') }}">
  </div>
  <ul class="uk-margin uk-nav-default uk-nav-parent-icon navbarnav" uk-nav>
    <li><a href="#">Dashboard</a></li>
    <li><a href="{{ route('admin_deviceconnected') }}">Device Connected</a></li>
    <li class="uk-parent">
      <a href="#">Administration</a>
      <ul class="uk-nav-sub">
        <li><a href="#">Log</a></li>
        <li><a href="#">Admin Roles</a></li>
      </ul>
    </li>
    <li><a href="#">Sign Out</a></li>
  </ul>
</nav>
