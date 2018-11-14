<template>
  <div class="uk-container uk-margin-large-top">
    <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-2-3@m uk-width-1-2@s uk-align-center">
      <img class="uk-width-1-3 uk-align-center" :src="url + 'images/logo/biznetwifi_primary.png'" alt="">
      <div class="uk-card uk-card-body uk-card-default login-container">
        <h4 class="login-heading">Log In</h4>
        <form class="uk-form-stacked" @submit.prevent="doLogin">
          <div class="uk-margin">
            <div class="uk-form-controls">
              <div class="uk-width-1-1 uk-inline">
                <span class="uk-form-icon" uk-icon="user"></span>
                <input type="text" class="uk-width-1-1 uk-input loginform" v-model="username" placeholder="Username">
              </div>
            </div>
          </div>

          <div class="uk-margin">
            <div class="uk-form-controls">
              <div class="uk-width-1-1 uk-inline">
                <span class="uk-form-icon" uk-icon="lock"></span>
                <input type="password" class="uk-width-1-1 uk-input loginform" v-model="password" placeholder="Password">
              </div>
            </div>
          </div>

          <div class="uk-margin">
            <button v-html="btnSubmit" class="uk-width-1-1 uk-button uk-button-default btnlogin">Log In</button>
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
            username: '',
            password: '',
            btnSubmit: 'Log In'
          }
        },
        methods: {
          doLogin() {
            axios({
              method: 'post',
              url: this.url + 'admin/auth/login',
              params: {
                username: this.username,
                password: this.password
              }
            }).then(res => {
              let results = res.data;
              console.log(res.status);
            });
          }
        },
        mounted() {

        }
    }
</script>
