require('bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import App from './App.vue';
import '../../css/app.css'
import router from './router/routes';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import axios from 'axios'
import VueAxios from 'vue-axios'
import lang from 'element-ui/lib/locale/lang/vi'
import locale from 'element-ui/lib/locale'
import store from '../store';
import './middleware';
import '../utils/logging';
import appConfig from '/config/appConfig'
Vue.prototype.$appSetting = appConfig
// configure language
locale.use(lang)
Vue.use(VueAxios, axios);
window.axios = require('axios');

Vue.use(VueRouter);
Vue.use(ElementUI,{ size: 'small', zIndex: 3000 });
// window.axios = require('axios');
import moment from 'moment'
Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('MM/DD/YYYY hh:mm')
  }
})

// register global utility filters.
import * as filters from '../filters';
Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key]);
});



new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
});
