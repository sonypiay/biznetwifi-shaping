<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
@include('administrator.includes.meta-header')
<title>BiznetWifi @yield('tag_admin_title')</title>
</head>
<body>
<header class="headertop">
  <section class="uk-container">
    <nav class="uk-navbar" uk-navbar>
      <div class="uk-navbar-left">
        <a href="{{ route('admin_dashboard') }}" class="uk-navbar-item uk-logo">
          <img class="navbarlogo" src="{{ asset('images/logo/biznetwifi_primary.png') }}" alt="">
        </a>
      </div>
      <div class="uk-navbar-right">
        <ul class="uk-navbar-nav navbartop">
          <li><a href="#">Hi, {{ $roles->fullname }} <span class="uk-float-right" uk-icon="chevron-down"></span></a>
            <div class="uk-navbar-dropdown">
              <ul class="uk-nav uk-navbar-dropdown-nav">
                <li><a href="#">Settings</a></li>
                <li><a href="{{ route('admin_signout') }}">Log Out</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </section>
  <section class="subheadertop">
    <div class="uk-container">
      <nav class="uk-navbar" uk-navbar>
        <div class="uk-navbar-left">
          <ul class="uk-navbar-nav subnavbartop">
            <li>
              <a @if( $request->route()->getName() === 'admin_dashboard' ) class="subnav-active" @endif href="{{ route('admin_dashboard') }}">
                <div>
                  <span class="uk-margin-small-right" uk-icon="home"></span>
                  Dashboard
                </div>
                <div class="nav-active-border"></div>
              </a>
          </li>
            <li>
              <a @if( $request->route()->getName() === 'admin_deviceconnected' ) class="subnav-active" @endif href="{{ route('admin_deviceconnected') }}">
                <div>
                  <span class="uk-margin-small-right" uk-icon="laptop"></span>
                  Devices
                </div>
              </a>
            </li>
            <li>
              <a @if( $request->route()->getName() === 'admin_log_activity_pages' || $request->route()->getName() === 'admin_roles_page' ) class="subnav-active" @endif>
                <div>
                  <span class="uk-margin-small-right" uk-icon="settings"></span> Administrator
                </div>
              </a>
              <div class="uk-navbar-dropdown">
                <ul class="uk-nav uk-navbar-dropdown-nav">
                  <li><a href="{{ route('admin_log_activity_pages') }}">Admin Activities</a></li>
                  <li><a href="{{ route('admin_roles_page') }}">Admin Roles</a></li>
                </ul>
              </div>
            </li>
            <li>
              <a href="#">
                <div>
                  <span class="uk-margin-small-right" uk-icon="users"></span> Clients
                </div>
              </a>
              <div class="uk-navbar-dropdown">
                <ul class="uk-nav uk-navbar-dropdown-nav">
                  <li><a href="#">As Visitor</a></li>
                  <li><a href="#">As Subscribers</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </section>
</header>
<div class="uk-margin-top uk-container">
  <div id="app">@yield('main_section')</div>
  <script type="text/javascript" src="{{ asset('js/admin/app.administrator.js') }}"></script>
</div>
</body>
</html>
