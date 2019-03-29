<template>
  <div class="uk-container uk-margin-large-top">
    <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-2-3@m uk-width-1-2@s uk-align-center">
      <div class="uk-tile uk-tile-default login-container">
        <img class="uk-width-1-2 uk-align-center" :src="url + 'images/logo/biznetwifi_primary.png'" alt="">
        <!--<div class="uk-margin login-heading">Sign In</div>-->
        <form class="uk-form-stacked" @submit.prevent="doLogin">
          <div v-if="errorMessage" class="uk-alert-danger" uk-alert>{{ errorMessage }}</div>
          <div class="uk-margin">
            <div class="uk-form-controls">
              <input type="text" class="uk-width-1-1 uk-input loginform" v-model="forms.username" placeholder="Username">
            </div>
            <div v-if="errors.username" class="uk-text-danger uk-text-small">{{ errors.username }}</div>
          </div>
          <div class="uk-margin">
            <div class="uk-form-controls">
              <input type="password" class="uk-width-1-1 uk-input loginform" v-model="forms.password" placeholder="Password">
            </div>
            <div v-if="errors.password" class="uk-text-danger uk-text-small">{{ errors.password }}</div>
          </div>
          <div class="uk-margin">
            <button v-html="forms.submit" class="uk-width-1-1 uk-button uk-button-default btnlogin"></button>
          </div>
        </form>
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
        password: '',
        submit: 'Sign In',
        error: false
      },
      errors: {},
      errorMessage: ''
    }
  },
  methods: {
    doLogin() {
      this.errors = {};
      this.errorMessage = '';
      if( this.forms.username === '' )
      {
        this.errors.username = 'Username must be required';
        this.forms.error = true;
      }
      if( this.forms.password === '' )
      {
        this.errors.password = 'Password must be required';
        this.forms.error = true;
      }

      if( this.forms.error === true )
      {
        this.forms.error = false;
        return false;
      }

      this.forms.submit = '<span uk-spinner></span>';
      axios({
        method: 'post',
        url: this.url + 'admin/auth/login',
        headers: { 'Content-Type': 'application/json' },
        params: {
          username: this.forms.username,
          password: this.forms.password
        }
      }).then(res => {
        let results = res.data;
        swal({
          title: 'Authorization Granted',
          text: 'Redirecting to dashboard page....',
          icon: 'success'
        });
        var redirect = this.url + 'admin/dashboard';
        setTimeout(function(){
          document.location = redirect;
        }, 2000);
      }).catch( err => {
        if( err.response.status === 403 )
        {
          this.errorMessage = err.response.data.statusText;
        }
        else
        {
          this.errorMessage = err.response.statusText;
        }
        this.forms.submit = 'Sign In';
      });
    }
  }
}
</script>
