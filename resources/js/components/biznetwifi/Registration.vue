<template>
  <div class="bzw-content-login">
    <!--<div class="uk-cover-container">
    <div uk-slideshow="autoplay: true; animation: fade">
      <ul class="uk-slideshow-items" uk-height-viewport>
        <li>
          <img v-bind:src="url + '/images/banner/Banner1.jpg'" uk-cover />
          <div class="uk-overlay uk-overlay-primary uk-position-cover overlay-bzw-login">

          </div>
        </li>
        <li>
          <img v-bind:src="url + '/images/banner/Banner2.jpg'" uk-cover />
          <div class="uk-overlay uk-overlay-primary uk-position-cover overlay-bzw-login"></div>
        </li>
        <li>
          <img v-bind:src="url + '/images/banner/banner3.jpg'" uk-cover />
          <div class="uk-overlay uk-overlay-primary uk-position-cover overlay-bzw-login"></div>
        </li>
      </ul>
    </div>
    </div>-->
    <div class="uk-position-cover">
      <div
        class="uk-container uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-2-3@s uk-align-center"
      >
        <div class="container-bzw-login">
          <div class="uk-tile uk-box-shadow-large card-bzw-login">
            <div class="bzw-logo-login">
              <img
                class="uk-width-1-2 uk-align-center"
                :src="url + '/images/logo/biznetwifi_white.png'"
                alt="biznetwifi"
              >
            </div>
            <div class="uk-light uk-text-center">
              <h2>{{ connectlocale.reg_form.title }}</h2>
              <p>{{ connectlocale.reg_form.title_2 }}</p>
            </div>
            <!--<div class="bzw-heading-login">{{ connectlocale.biznetwifi.login_heading }}</div>-->
            <form class="uk-form-stacked" @submit.prevent="doRegistration">
              <div class="uk-margin">
                <!--<label class="uk-form-label bzw-form-label">{{ connectlocale.loginform.username }}</label>-->
                <div class="uk-form-controls">
                  <div class="uk-width-1-1 uk-inline">
                    <span uk-icon="user" class="uk-form-icon bzw-form-icon"></span>
                    <input
                      type="text"
                      class="uk-width-1-1 uk-input bzw-form-login"
                      :placeholder="connectlocale.reg_form.full_name"
                      v-model="forms.full_name"
                    >
                  </div>
                </div>
                <div v-if="errors.full_name" class="uk-text-small uk-text-danger">{{ errors.full_name }}</div>
              </div>
              <div class="uk-margin">
                <!--<label class="uk-form-label bzw-form-label">{{ connectlocale.loginform.username }}</label>-->
                <div class="uk-form-controls">
                  <div class="uk-width-1-1 uk-inline">
                    <span uk-icon="mail" class="uk-form-icon bzw-form-icon"></span>
                    <input
                      type="text"
                      class="uk-width-1-1 uk-input bzw-form-login"
                      :placeholder="connectlocale.reg_form.email"
                      v-model="forms.email"
                    >
                  </div>
                </div>
                <div v-if="errors.email" class="uk-text-small uk-text-danger">{{ errors.email }}</div>
              </div>
              <div class="uk-margin">
                <!--<label class="uk-form-label bzw-form-label">{{ connectlocale.loginform.username }}</label>-->
                <div class="uk-form-controls">
                  <div class="uk-width-1-1 uk-inline">
                    <span uk-icon="receiver" class="uk-form-icon bzw-form-icon"></span>
                    <input
                      type="text"
                      class="uk-width-1-1 uk-input bzw-form-login"
                      :placeholder="connectlocale.reg_form.phone"
                      v-model="forms.phone"
                    >
                  </div>
                </div>
                <div v-if="errors.phone" class="uk-text-small uk-text-danger">{{ errors.phone }}</div>
              </div>
              <div class="uk-margin">
                <!--<label class="uk-form-label bzw-form-label">{{ connectlocale.loginform.username }}</label>-->
                <div class="uk-form-controls">
                  <div class="uk-width-1-1 uk-inline">
                    <span uk-icon="user" class="uk-form-icon bzw-form-icon"></span>
                    <input
                      type="text"
                      class="uk-width-1-1 uk-input bzw-form-login"
                      :placeholder="connectlocale.reg_form.username"
                      v-model="forms.username"
                    >
                  </div>
                </div>
                <div v-if="errors.username" class="uk-text-small uk-text-danger">{{ errors.username }}</div>
              </div>
              <div class="uk-margin">
                <!--<label class="uk-form-label bzw-form-label">{{ connectlocale.loginform.password }}</label>-->
                <div class="uk-form-controls">
                  <div class="uk-width-1-1 uk-inline">
                    <span uk-icon="lock" class="uk-form-icon bzw-form-icon"></span>
                    <input
                      type="password"
                      class="uk-width-1-1 uk-input bzw-form-login"
                      :placeholder="connectlocale.reg_form.password"
                      v-model="forms.password"
                    >
                  </div>
                </div>
                <div v-if="errors.password" class="uk-text-small uk-text-danger">{{ errors.password }}</div>
              </div>
              <div class="uk-margin">
                <!--<label class="uk-form-label bzw-form-label">{{ connectlocale.loginform.password }}</label>-->
                <div class="uk-form-controls">
                  <div class="uk-width-1-1 uk-inline">
                    <span uk-icon="lock" class="uk-form-icon bzw-form-icon"></span>
                    <input
                      type="password"
                      class="uk-width-1-1 uk-input bzw-form-login"
                      :placeholder="connectlocale.reg_form.confirm_password"
                      v-model="forms.confirm_password"
                    >
                  </div>
                </div>
                <div v-if="errors.confirm_password" class="uk-text-small uk-text-danger">{{ errors.confirm_password }}</div>
              </div>
              <div class="uk-margin">
                <button
                  v-html="btnSubmit"
                  class="uk-width-1-1 uk-button uk-button-default bzw-button-login"
                ></button>
              </div>
            </form>
            <div class="uk-text-center copyright-login">&copy; 2000 - {{ getMoment() }} Biznet.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["url", "connectlocale"],
  data() {
    return {
      forms: {
        full_name: "",
        email: "",
        phone: "",
        username: "",
        password: "",
        confirm_password: "",
        error: false
      },
      errors: {},
      btnSubmit: this.connectlocale.reg_form.btnRegister,
      phoneRE: /^[0-9]*$/,
      emailRE: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/
    };
  },
  methods: {
    doRegistration() 
    {
      this.errors = {};
      this.forms.error = false;

      if (this.forms.full_name === "") {
        this.forms.error = true;
        this.errors.full_name = this.connectlocale.reg_form_errors.full_name;
      }

      if (this.forms.email === "") {
        this.forms.error = true;
        this.errors.email = this.connectlocale.reg_form_errors.email;
      } else {
        if (!this.emailRE.test(this.forms.email)) {
          this.forms.error = true;
          this.errors.email = this.connectlocale.reg_form_errors.email_not_valid;
        }
      }

      if (this.forms.phone !== "") {
        if (!this.phoneRE.test(this.forms.phone)) {
          this.forms.error = true;
          this.errors.phone = this.connectlocale.reg_form_errors.phone_not_valid;
        }
      }

      if (this.forms.username === "") {
        this.forms.error = true;
        this.errors.username = this.connectlocale.reg_form_errors.username;
      }

      if (this.forms.password === "") {
        this.forms.error = true;
        this.errors.password = this.connectlocale.reg_form_errors.password;
      }

      if (this.forms.confirm_password === "") {
        this.forms.error = true;
        this.errors.confirm_password = this.connectlocale.reg_form_errors.confirm_password;
      }

      if (this.forms.password !== "" && this.forms.confirm_password !== "") {
        if (this.forms.password !== this.forms.confirm_password) {
          this.forms.error = true;
          this.errors.confirm_password = this.connectlocale.reg_form_errors.confirm_password_not_match;
        }
      }

      if (!this.forms.error) {
        this.btnSubmit = "<span uk-spinner></span>";
        axios({
          method: "post",
          url: this.url + "/biznetwifi/registration",
          headers: { "Content-Type": "application/json" },
          params: {
            member: this.forms
          }
        }).then(res => {
            let result = res.data;
            swal({
              title: this.connectlocale.noerror,
              text: "Redirecting...",
              icon: "success"
            });
            var redirect = this.url + "/biznetwifi/customers";
            setTimeout(function() {
              document.location = redirect;
            }, 2000);
        }).catch(err => {
            if (err.response.status === 401) {
              swal({
                title: "Warning",
                text: err.response.data.statusText,
                icon: "warning",
                dangerMode: true
              });
            } else {
              swal({
                title: "Error",
                text: err.response.data.statusText,
                icon: "error",
                dangerMode: true
              });
            }
            this.btnSubmit = this.connectlocale.reg_form.btnRegister;
        });
      }
    },
    getMoment() {
      var now = moment().format("Y");
      return now;
    }
  },
  mounted() {}
};
</script>

<style lang="css">
  .bzw-content-login {
    min-height: calc(145vh);
  }
</style>
