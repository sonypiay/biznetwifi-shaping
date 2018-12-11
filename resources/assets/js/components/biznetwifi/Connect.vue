<template lang="html">
  <div>
    <div id="loginCustomer" class="uk-modal-full" uk-modal>
      <div class="uk-modal-dialog modal-dialog">
        <a class="uk-modal-close-default" uk-close></a>
        <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-1@s uk-align-center uk-modal-body modal-body" uk-height-viewport>
          <div class="uk-width-2-3@xl uk-width-2-3@l uk-width-3-4@m uk-width-2-3@s uk-align-center">
            <div class="uk-margin-large-top modal-heading">Login Akun Biznet</div>
            <div class="uk-width-1-1 uk-padding-small uk-align-center uk-margin-bottom modal-subheading">
              <span class="uk-text-center">Layanan Wi-Fi Turbo untuk pelanggan Biznet dengan kecepatan hingga 100 Mbps!</span>
            </div>
            <div class="uk-card uk-card-body uk-card-small uk-card-default login-container">
              <form class="uk-form-stacked" @submit.prevent="doLoginCustomer">
                <div class="uk-margin">
                  <div class="uk-form-controls">
                    <span v-if="errors.username">
                      <div class="uk-alert-warning uk-margin-top" uk-alert>{{ errors.username }} <a class="uk-alert-close" uk-close></a></div>
                    </span>
                    <div class="uk-width-1-1 uk-inline">
                      <span class="uk-form-icon" uk-icon="user"></span>
                      <input type="text" v-model="username" class="uk-width-1-1 uk-input form-login-customer" placeholder="Customer ID">
                    </div>
                  </div>
                </div>
                <div class="uk-margin">
                  <div class="uk-form-controls">
                    <span v-if="errors.password">
                      <div class="uk-alert-warning uk-margin-top" uk-alert>{{ errors.password }} <a class="uk-alert-close" uk-close></a></div>
                    </span>
                    <div class="uk-width-1-1 uk-inline">
                      <span class="uk-form-icon" uk-icon="lock"></span>
                      <input type="password" v-model="password" class="uk-width-1-1 uk-input form-login-customer" placeholder="Password">
                    </div>
                  </div>
                </div>
                <div class="uk-margin">
                  <button v-html="btnSubmit" class="uk-width-1-1 uk-button uk-button-default button-login-customer" id="btnSubmit">Log In</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="uk-cover-container" uk-height-viewport>
      <img v-bind:src="url + '/images/banner/banner3.jpg'" uk-cover />
      <div class="uk-overlay uk-overlay-primary uk-position-cover uk-padding-remove overlay">
         <nav class="uk-navbar uk-box-shadow-medium navbar" uk-navbar>
      			<div class="uk-navbar-left">
      				<a class="uk-navbar-item uk-logo" href="#">
      					<img class="logo-nav" v-bind:src="url + '/images/logo/biznetwifi_primary.png'" />
      				</a>
      			</div>
      		</nav>
      		<div class="uk-position-center">
            <div class="uk-container padding-landingpage">
              <div class="uk-text-center banner-heading">Biznet Wifi</div>
              <div class="uk-text-center banner-subheading">Wi-Fi Gratis dari Biznet</div>
              <div class="uk-text-center lead-banner">
                Cara mudah mendapatkan banyak hal baru melalui akses internet terbaik.
                <br>Mulai sekarang untuk segera terkoneksi.
              </div>
              <div class="uk-grid-small uk-margin-top" uk-grid>
                <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-2@s">
                  <a :href="url + '/freehotspot?ap=' + ap + '&src=BiznetHotspot&loc=' + loc.origin + '&uip=' + uip + '&client_mac=' + client_mac + '&starturl=' + starturl + '&ssid=' + ssid" class="uk-display-block uk-button login-connect login-visitor">
                    Login sebagai Pengunjung
                  </a>
                </div>
                <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-2@s">
                  <a uk-toggle="target: #loginCustomer" class="uk-display-block uk-button login-connect login-customer">
                    Login Akun Biznet
                  </a>
                </div>
              </div>
            </div>
      		</div>
      </div>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert';
export default {
  props: [
    'url', 'client_mac','uip','ssid','starturl','loc','ap'
  ],
  data() {
    return {
      username: '',
      password: '',
      btnSubmit: 'Log In',
      errors: {}
    }
  },
  methods: {
    doLoginCustomer()
    {
      if( this.username === '' )
      {
        /*swal({
          title: 'Warning',
          text: 'Silahkan masukkan Customer ID Anda.',
          icon: 'warning',
          dangerMode: true
        });*/
      }

      else if( this.password === '' )
      {
        /*swal({
          title: 'Warning',
          text: 'Silahkan masukkan password Anda.',
          icon: 'warning',
          dangerMode: true
        });*/
      }
      else
      {
        this.btnSubmit = '<span uk-spinner></span>';
        axios({
          method: 'post',
          url: this.url + '/biznetwifi/auth',
          headers: { 'Content-Type': 'application/json' },
          params: {
            username: this.username,
            password: this.password
          }
        }).then( res => {
          let result = res.data;
          swal({
            title: 'Login berhasil',
            text: 'Redirecting',
            icon: 'success'
          });

          var redirect = this.url + '/biznetwifi/customers';
          if( this.client_mac === ''
            && this.uip === ''
            && this.ssid === ''
            && this.loc === '')
          {
            setTimeout(function() { document.location = redirect; }, 2000);
          }
          else
          {
            var username_radius = 'shaping';
            var password_radius = 'biznet01';
            if( this.ap === 'ruckus' ) {
              redirect = 'http://10.132.0.5:9997/SubscriberPortal/hotspotlogin?username=' + username_radius + '&password=' + password_radius + '&uip=' + this.uip + '&client_mac=' + this.client_mac + '&ssid=' + this.ssid + '&starturl=' + this.starturl;
            }
            else
            {
              redirect = 'http://10.10.10.10/login?username=' + username_radius + '&password=' + password_radius + '&client_mac=' + this.client_mac + '&uip=' + this.uip;
            }
            setTimeout(function() { document.location = redirect; }, 2000);
          }
        }).catch( err => {
          if( err.response.status === 401 )
          {
            swal({
              title: 'Warning',
              text: err.response.data.statusText,
              icon: 'warning',
              dangerMode: true
            });
          }
          else
          {
            swal({
              title: 'Error',
              text: err.response.data.statusText,
              icon: 'error',
              dangerMode: true
            });
          }

          this.btnSubmit = 'Log In';
        });
      }
    }
  },
  mounted() {}
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
</style>
