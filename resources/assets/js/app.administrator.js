
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

Vue.component('section-login', require('./components/administrator/Login.vue'));
Vue.component('device-connected', require('./components/administrator/DeviceConnected.vue'));
Vue.component('admin-log-activity', require('./components/administrator/AdminLogActivity.vue'));
Vue.component('admin-roles', require('./components/administrator/AdminRoles.vue'));

const app = new Vue({
    el: '#app',
    data: {
      formatDate(str, format) {
        var res = moment(str).locale('en').format(format);
        return res;
      }
    }
});
