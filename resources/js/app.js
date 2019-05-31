require('./bootstrap');

window.Vue = require('vue');

Vue.component('connect-section', require('./components/biznetwifi/Connect.vue').default);
Vue.component('customers-dashboard', require('./components/biznetwifi/CustomersDashboard.vue').default);
Vue.component('members-dashboard', require('./components/biznetwifi/MembersDashboard.vue').default);
Vue.component('login-biznetwifi', require('./components/biznetwifi/LoginCustomers.vue').default);
Vue.component('login-member', require('./components/biznetwifi/LoginMember.vue').default);
Vue.component('registration-biznetwifi', require('./components/biznetwifi/Registration.vue').default);
Vue.component('homepage', require('./components/biznetwifi/Homepage.vue').default);

const app = new Vue({
    el: '#app',
    data: {
      getLocale: biznetwifi_locale
    }
});
