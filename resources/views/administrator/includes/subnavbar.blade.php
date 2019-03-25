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
      <!--<li>
        <a @if( $request->route()->getName() === 'admin_accountsubscriber' ) class="subnav-active" @endif href="{{ route('admin_accountsubscriber') }}">
          <div>
            <span class="uk-margin-small-right" uk-icon="laptop"></span>
            Account Subscribers
          </div>
        </a>
      </li>-->
      <li>
        <a href="#">
          <div>
            <span class="uk-margin-small-right" uk-icon="users"></span> Clients
          </div>
        </a>
        <div class="uk-navbar-dropdown">
          <ul class="uk-nav uk-navbar-dropdown-nav">
            <li><a href="{{ route('admin_client_visitor_page') }}">Clients Visitor</a></li>
            <li><a href="{{ route('admin_accountsubscriber') }}">Clients Subscribers</a></li>
          </ul>
        </div>
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
    </ul>
  </div>
</nav>
