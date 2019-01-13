
require('./bootstrap');
require('jquery-ui');
require('bootstrap');
require('jquery-slimscroll');
require('moment');
require('fastclick');
require('./plugins/adminlte');
require('datatables.net-bs');


window.Vue = require('vue');
window.swal = require('sweetalert')
window.toast = require('toastr')

import VueCookies from 'vue-cookies'
import router from './router'
import store from './store'
import mixins from './mixins'


Vue.mixin(mixins)
Vue.use(VueCookies)

import Storage from 'vue-localstorage'

Vue.use(Storage)

Vue.component('example-component', require('./components/ExampleComponent.vue'));


const app = new Vue({
    el: '#app',
    router,
    store
});
