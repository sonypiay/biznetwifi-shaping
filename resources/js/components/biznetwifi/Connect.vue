<template>
  <div>
    <div id="loginCustomer" class="uk-modal-full" uk-modal="esc-close: false;">
      <div class="uk-modal-dialog modal-dialog">
        <div class="uk-modal-body modal-body" uk-height-viewport>
          <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-3-4@m uk-width-2-3@s uk-align-center">
            <a @click="closeLoginAsBiznet()" class="uk-modal-close-default" uk-close></a>
            <div class="uk-margin-large-top modal-heading">{{ connectlocale.biznetwifi.login_heading }}</div>
            <div class="uk-width-1-1 uk-padding-small uk-align-center uk-margin-bottom modal-subheading">
              <span class="uk-text-center">{{ connectlocale.biznetwifi.service }}</span>
            </div>
            <div class="uk-card uk-card-body uk-card-small uk-card-default login-container">
              <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
              <form class="uk-form-stacked" @submit.prevent="doLoginCustomer">
                <div class="uk-margin">
                  <div class="uk-form-controls">
                    <div class="uk-width-1-1 uk-inline">
                      <span class="uk-form-icon" uk-icon="user"></span>
                      <input type="text" v-model="forms.username" class="uk-width-1-1 uk-input form-login-customer" :placeholder="connectlocale.loginform.username">
                    </div>
                  </div>
                  <div v-if="errors.username" class="uk-text-small uk-text-danger">{{ errors.username }}</div>
                </div>
                <div class="uk-margin">
                  <div class="uk-form-controls">
                    <div class="uk-width-1-1 uk-inline">
                      <span class="uk-form-icon" uk-icon="lock"></span>
                      <input type="password" v-model="forms.password" class="uk-width-1-1 uk-input form-login-customer" :placeholder="connectlocale.loginform.password">
                    </div>
                  </div>
                  <div v-if="errors.password" class="uk-text-small uk-text-danger">{{ errors.password }}</div>
                </div>
                <div class="uk-margin">
                  <button v-html="forms.btnSubmit" class="uk-width-1-1 uk-button uk-button-default button-login-customer"></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="uk-cover-container">
      <div uk-slideshow="autoplay: true; animation: fade">
        <ul class="uk-slideshow-items" uk-height-viewport>
          <li>
            <img v-bind:src="url + '/images/banner/Banner1.jpg'" uk-cover />
            <div class="uk-overlay uk-overlay-primary uk-position-cover overlay"></div>
          </li>
          <li>
            <img v-bind:src="url + '/images/banner/Banner2.jpg'" uk-cover />
            <div class="uk-overlay uk-overlay-primary uk-position-cover overlay"></div>
          </li>
          <li>
            <img v-bind:src="url + '/images/banner/banner3.jpg'" uk-cover />
            <div class="uk-overlay uk-overlay-primary uk-position-cover overlay"></div>
          </li>
        </ul>
      </div>
    </div>
    <div class="uk-position-cover overlay">
       <nav class="uk-navbar uk-box-shadow-medium navbar" uk-navbar>
          <div class="uk-navbar-left">
            <a class="uk-navbar-item uk-logo" href="#">
              <img class="logo-nav" :src="url + '/images/logo/biznetwifi_primary.png'" />
            </a>
          </div>
          <div class="uk-navbar-right">
            <ul class="uk-navbar-nav navlang">
              <li>
                <a v-if="$root.getLocale === 'id'" class="lang_active"><span>ID</span></a>
                <a v-else @click="switchLocale('id')"><span>ID</span></a>
              </li>
              <li>
                <a v-if="$root.getLocale === 'en'" class="lang_active"><span>EN</span></a>
                <a v-else @click="switchLocale('en')"><span>EN</span></a>
              </li>
            </ul>
          </div>
        </nav>
        <div class="uk-position-center">
          <div class="uk-container padding-landingpage">
            <div class="uk-text-center banner-heading">Biznet Wifi</div>
            <div class="uk-text-center banner-subheading">{{ homepagelocale.freewifi.frombiznet }}</div>
            <div class="uk-text-center lead-banner" v-html="homepagelocale.freewifi.textcontent"></div>
            <div class="uk-grid-small uk-margin-top" uk-grid>
              <div class="uk-width-expand">
                <a @click="doLoginHotspot()" class="uk-display-block uk-button login-connect login-visitor" v-html="forms.btnhotspot"></a>
              </div>
              <!-- <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-2@s">
                <a uk-toggle="target: #loginCustomer" class="uk-display-block uk-button login-connect login-customer">{{ connectlocale.connect.biznetwifi }}</a>
              </div> -->
            </div>
          </div>
        </div>
    </div>

    <div>
        <div class="uk-section uk-section-default" id="loginSection">
            <div class="uk-container">
                <div class="uk-panel uk-light uk-margin-medium uk-text-center">
                    <h2>{{ connectlocale.connect.biznetwifi_login_title }}</h2>
                    <p>{{ connectlocale.connect.biznetwifi_login_title_2 }}</p>
                </div>

                <div class="uk-grid-large uk-child-width-1-2@m" uk-grid>
                    <div>
                        <div class="uk-card uk-card-default uk-card-body uk-card-small __login-card">
                            <form class="uk-form-stacked" @submit.prevent="doLoginMember">
                                <legend class="uk-legend uk-text-center">{{ connectlocale.connect.biznetwifi_member }}</legend>
                                <div v-if="errorMessageMember" class="uk-alert-danger" uk-alert>{{ errorMessageMember }}</div>
                                <div class="uk-margin">
                                    <div class="uk-form-controls">
                                        <div class="uk-width-1-1 uk-inline">
                                            <span class="uk-form-icon" uk-icon="user"></span>
                                            <input type="text" v-model="forms.usernameMember" class="uk-width-1-1 uk-input form-login-customer" :placeholder="connectlocale.loginform.username">
                                        </div>
                                    </div>
                                    <div v-if="errors.usernameMember" class="uk-text-small uk-text-danger">{{ errors.usernameMember }}</div>
                                </div>
                                <div class="uk-margin">
                                    <div class="uk-form-controls">
                                        <div class="uk-width-1-1 uk-inline">
                                            <span class="uk-form-icon" uk-icon="lock"></span>
                                            <input type="password" v-model="forms.passwordMember" class="uk-width-1-1 uk-input form-login-customer" :placeholder="connectlocale.loginform.password">
                                        </div>
                                    </div>
                                    <div v-if="errors.passwordMember" class="uk-text-small uk-text-danger">{{ errors.passwordMember }}</div>
                                </div>
                                <div class="uk-margin">
                                    <button v-html="forms.btnSubmitMember" class="uk-width-1-1 uk-button uk-button-default button-login-customer"></button>
                                </div>
                                <div class="uk-text-center">
                                    <a v-bind:href="url +'/biznetwifi/registration'" class="uk-link-text uk-text-small uk-text-muted">{{ connectlocale.loginform.registration }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div>
                        <div class="uk-card uk-card-default uk-card-body uk-card-small __login-card">
                            <form class="uk-form-stacked" @submit.prevent="doLoginCustomer">
                                <legend class="uk-legend uk-text-center">{{ connectlocale.connect.biznetwifi }}</legend>
                                <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
                                <div class="uk-margin">
                                    <div class="uk-form-controls">
                                        <div class="uk-width-1-1 uk-inline">
                                            <span class="uk-form-icon" uk-icon="user"></span>
                                            <input type="text" v-model="forms.username" class="uk-width-1-1 uk-input form-login-customer" :placeholder="connectlocale.loginform.username">
                                        </div>
                                    </div>
                                    <div v-if="errors.username" class="uk-text-small uk-text-danger">{{ errors.username }}</div>
                                </div>
                                <div class="uk-margin">
                                    <div class="uk-form-controls">
                                        <div class="uk-width-1-1 uk-inline">
                                            <span class="uk-form-icon" uk-icon="lock"></span>
                                            <input type="password" v-model="forms.password" class="uk-width-1-1 uk-input form-login-customer"
                                                :placeholder="connectlocale.loginform.password">
                                        </div>
                                    </div>
                                    <div v-if="errors.password" class="uk-text-small uk-text-danger">{{ errors.password }}</div>
                                </div>
                                <div class="uk-margin">
                                    <button v-html="forms.btnSubmit" class="uk-width-1-1 uk-button uk-button-default button-login-customer"></button>
                                </div>
                                <div class="uk-text-center">&nbsp;</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>

export default {
  props: [
    'url', 'client_mac','uip','ssid','starturl','loc','ap','shaping',
    'connectlocale','homepagelocale'
  ],
  data() {
    return {
      forms: {
        username: '',
        password: '',
        usernameMember: '',
        passwordMember: '',
        btnSubmit: this.connectlocale.biznetwifi.btnlogin,
        btnSubmitMember: this.connectlocale.biznetwifi.btnlogin,
        btnhotspot: this.connectlocale.connect.freehotspot,
        error: false
      },
      errors: {},
      errorMessage: '',
      errorMessageMember: ''
    }
  },
  methods: {
    doLoginCustomer()
    {
      this.errors = {};
      this.errorMessage = '';
      if( this.forms.username === '' )
      {
        this.forms.error = true;
        this.errors.username = this.connectlocale.errors.username;
      }

      if( this.forms.password === '' )
      {
        this.forms.error = true;
        this.errors.password = this.connectlocale.errors.password;
      }

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return false;
      }

      ga('send', {hitType: 'event', eventCategory: 'Button', eventAction: 'click', eventLabel: 'LoginAsBiznet'});

      this.forms.btnSubmit = '<span uk-spinner></span>';
      axios({
        method: 'post',
        url: this.url + '/biznetwifi/auth',
        headers: { 'Content-Type': 'application/json' },
        params: {
          username: this.forms.username,
          password: this.forms.password
        }
      }).then( res => {
        let result = res.data;
        /*swal({
          title: 'Login berhasil',
          text: 'Redirecting',
          icon: 'success'
        });*/
        var redirect = this.url + '/biznetwifi/customers';
        if( this.client_mac === ''
          && this.uip === ''
          && this.ssid === ''
          && this.loc === '')
        {
          setTimeout(function() { document.location = redirect; }, 1000);
        }
        else
        {
          var username_radius = '9e1b9d0d7c59f0ed2a794f50015cf82339866406';
          var password_radius = 'e3e155b21531cc739bd78f36830ca697ec1d028b';
          if( this.ap === 'ruckus' ) {
            redirect = 'http://10.132.0.5:9997/SubscriberPortal/hotspotlogin?username=' + username_radius + '&password=' + password_radius + '&uip=' + this.uip + '&client_mac=' + this.client_mac + '&ssid=' + this.ssid + '&starturl=' + this.starturl;
          }
          else
          {
            redirect = 'http://10.10.10.10/login?username=' + username_radius + '&password=' + password_radius + '&client_mac=' + this.client_mac + '&uip=' + this.uip;
          }
          ga('send', {hitType: 'event', eventCategory: 'Success', eventAction: 'submit', eventLabel: 'Customer_ID'});
          setTimeout(function() { document.location = redirect; }, 1000);
        }
      }).catch( err => {
        if( err.response.status === 401 )
        {
          this.errorMessage = err.response.data.statusText;
        }
        else
        {
          this.errorMessage = err.response.statusText;
        }

        ga('send', {hitType: 'event', eventCategory: 'Error', eventAction: 'submit', eventLabel: 'AuthError'});
        this.forms.btnSubmit = 'Log In';
      });
    },
    doLoginHotspot()
    {
      var redirect = 'http://10.132.0.5:9997/SubscriberPortal/hotspotlogin?username=' + username_radius + '&password=' + password_radius + '&uip=' + this.uip + '&client_mac=' + this.client_mac + '&ssid=' + this.ssid + '&starturl=' + this.starturl;
      setTimeout(function(){
        document.location = redirect;
      }, 2000);
    },
    doLoginMember()
    {
      this.errors = {};
      this.errorMessageMember = '';
      if( this.forms.usernameMember === '' )
      {
        this.forms.error = true;
        this.errors.usernameMember = this.connectlocale.errors.username;
      }

      if( this.forms.passwordMember === '' )
      {
        this.forms.error = true;
        this.errors.passwordMember = this.connectlocale.errors.password;
      }

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return false;
      }

      ga('send', {hitType: 'event', eventCategory: 'Button', eventAction: 'click', eventLabel: 'LoginAsMember'});

      this.forms.btnSubmitMember = '<span uk-spinner></span>';
      axios({
        method: 'post',
        url: this.url + '/biznetwifi/authMember',
        headers: { 'Content-Type': 'application/json' },
        params: {
          username: this.forms.usernameMember,
          password: this.forms.passwordMember
        }
      }).then( res => {
        let result = res.data;
        /*swal({
          title: 'Login berhasil',
          text: 'Redirecting',
          icon: 'success'
        });*/
        var redirect = this.url + '/biznetwifi/customers';
        if( this.client_mac === ''
          && this.uip === ''
          && this.ssid === ''
          && this.loc === '')
        {
          setTimeout(function() { document.location = redirect; }, 1000);
        }
        else
        {
          var username_radius = 'biznetmember';
          var password_radius = 'biznet01';
          if( this.ap === 'ruckus' ) {
            redirect = 'http://10.132.0.5:9997/SubscriberPortal/hotspotlogin?username=' + username_radius + '&password=' + password_radius + '&uip=' + this.uip + '&client_mac=' + this.client_mac + '&ssid=' + this.ssid + '&starturl=' + this.starturl;
          }
          else
          {
            redirect = 'http://10.10.10.10/login?username=' + username_radius + '&password=' + password_radius + '&client_mac=' + this.client_mac + '&uip=' + this.uip;
          }
          ga('send', {hitType: 'event', eventCategory: 'Success', eventAction: 'submit', eventLabel: 'Customer_ID'});
          setTimeout(function() { document.location = redirect; }, 1000);
        }
      }).catch( err => {
        if( err.response.status === 401 )
        {
          this.errorMessageMember = err.response.data.statusText;
        }
        else
        {
          this.errorMessageMember = err.response.statusText;
        }

        ga('send', {hitType: 'event', eventCategory: 'Error', eventAction: 'submit', eventLabel: 'AuthError'});
        this.forms.btnSubmitMember = 'Log In';
      });
    },
    closeLoginAsBiznet()
    {
      ga('send', {hitType: 'event', eventCategory: 'Button', eventAction: 'click', eventLabel: 'CloseFormLogin'});
    },
    switchLocale(lang)
    {
      axios({
        method: 'post',
        url: this.url + '/change_locale/' + lang
      }).then( res => {
        setTimeout(function(){ document.location = ''; }, 100);
      }).catch( err => {
        console.log( err.response.statusText );
      });
    }
  }
}
</script>

<style>
  #loginCustomer { z-index: 9999; }
  .modal-dialog {
    background: rgba(0,0,0,0.7);
  }
  .modal-body {
    background: #ffffff;
    margin-bottom: 0;
  }
  .modal-heading {
    font-size: 36px;
    color: #333333;
    font-family: 'Univers', sans-serif;
    font-weight: 400;
    text-align: center;
  }
  .modal-subheading {
    font-size: 16px;
    color: #333333;
    font-family: 'Univers', sans-serif;
    font-weight: 400;
    text-align: center;
  }
  .login-container {
    box-shadow: none;
  }
  .form-login-customer {
    border-radius: 30px;
    font-size: 13px;
    color: #333333;
    font-family: 'Univers', sans-serif;
    font-weight: 400;
  }
  .form-login-customer:hover, .form-login-customer:focus {
    border: 1px solid #982e7e;
  }
  .button-login-customer {
    border-radius: 30px;
    border: 0;
    background: linear-gradient(97deg, #da068c, #982e7e)  !important;
    color: #ffffff;
    font-size: 13px;
    font-family: 'Univers', sans-serif;
    font-weight: 400;
  }
  .button-login-customer:hover, .button-login-customer:focus {
    background: linear-gradient(97deg, #da068c, #982e7e)  !important;
    color: #ffffff;
  }
  #loginSection { background: #a53089; }
  .__login-card { border-radius: 10px; }
</style>
