
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('connect-section', require('./components/biznetwifi/Connect.vue'));
Vue.component('customers-dashboard', require('./components/biznetwifi/CustomersDashboard.vue'));
Vue.component('login-biznetwifi', require('./components/biznetwifi/Login.vue'));
Vue.component('homepage', require('./components/biznetwifi/Homepage.vue'));

const app = new Vue({
    el: '#app',
    data: {
      getLocale: biznetwifi_locale
    }
});
