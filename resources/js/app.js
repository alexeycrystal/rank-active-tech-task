import Vue from 'vue';
import App from './App';

window.$ = require('jquery');

import router from './router';
import ApiService from './api/api.service';
import VueSelect from "vue-cool-select";
import VeeValidate from 'vee-validate';
import Notify from 'vue2-notify';
import VModal from 'vue-js-modal'

import { ClientTable} from 'vue-tables-2';
let options = {};
let useVuex = false;
let theme = "bootstrap4";
let template = "default";

Vue.use(VueSelect, {theme: 'bootstrap'});
Vue.use(VeeValidate);
Vue.use(Notify, {position: 'top-full'});
Vue.use(ClientTable, options, useVuex, theme, template);
Vue.use(VModal);

import vSelect from 'vue-select'
Vue.component('v-select', vSelect);

ApiService.init();

Vue.config.productionTip = false;

new Vue({
    router,
    render: h => h(App)
}).$mount('#app');
