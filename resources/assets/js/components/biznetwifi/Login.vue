<template lang="html">
<div class="bzw-content-login uk-height-viewport">
  <div class="uk-box-shadow-large bzw-bglogin"></div>
  <div class="uk-container container-bzw-login">
    <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-2-3@s uk-align-center">
      <div class="bzw-logo-login">
        <img class="uk-width-1-3 uk-align-center" :src="url + '/images/logo/biznetwifi_white.png'" alt="biznetwifi">
      </div>
      <div class="uk-card uk-card-body uk-card-default uk-box-shadow-large card-bzw-login">
        <div class="bzw-heading-login">Login</div>
        <form class="uk-form-stacked" @submit.prevent="doLogin">
          <div class="uk-margin">
            <label class="uk-form-label bzw-form-label">Customer ID</label>
            <div class="uk-form-controls">
              <div class="uk-width-1-1 uk-inline">
                <span uk-icon="user" class="uk-form-icon"></span>
                <input type="text" class="uk-width-1-1 uk-input bzw-form-login" placeholder="" v-model="forms.username">
              </div>
            </div>
          </div>
          <div class="uk-margin">
            <label class="uk-form-label bzw-form-label">Password</label>
            <div class="uk-form-controls">
              <div class="uk-width-1-1 uk-inline">
                <span uk-icon="lock" class="uk-form-icon"></span>
                <input type="password" class="uk-width-1-1 uk-input bzw-form-login" placeholder="" v-model="forms.password">
              </div>
            </div>
          </div>
          <div class="uk-margin">
            <button v-html="btnSubmit" class="uk-width-1-1 uk-button uk-button-default bzw-button-login">Login</button>
          </div>
        </form>
        <div class="uk-text-center copyright-login">&copy; 2000 - {{ getMoment() }} Biznet.</div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      forms: {
        username: '',
        password: ''
      },
      btnSubmit: 'Login'
    }
  },
  methods: {
    doLogin() {
      if( this.forms.username === '' )
      {
        swal({
          title: 'Warning',
          text: 'Silahkan masukkan Customer ID Anda.',
          icon: 'warning',
          dangerMode: true
        });
      }
      else if( this.forms.password === '' )
      {
        swal({
          title: 'Warning',
          text: 'Silahkan masukkan password Anda.',
          icon: 'warning',
          dangerMode: true
        });
      }
      else
      {
        this.btnSubmit = '<span uk-spinner></span>';
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
          swal({
            title: 'Login berhasil',
            text: 'Redirecting',
            icon: 'success'
          });
          var redirect = this.url + '/biznetwifi/customers';
          setTimeout(function() { document.location = redirect; }, 2000);
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
          this.btnSubmit = 'Login';
        });
      }
    },
    getMoment(){
      var now = moment().format('Y');
      return now;
    }
  },
  mounted() {}
}
</script>

<style lang="css">
</style>
