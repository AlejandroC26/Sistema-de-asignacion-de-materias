import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import VueSweetalert2 from 'vue-sweetalert2';
import JsonExcel from "vue-json-excel";
 
import axios from 'axios'
import VueAxios from 'vue-axios'

import 'sweetalert2/dist/sweetalert2.min.css';
import '@/assets/style/main.css';
import '@/assets/style/global.css';


Vue.config.productionTip = false
Vue.use(VueAxios, axios)
Vue.use(VueSweetalert2);
Vue.use(require('vue-moment'));
Vue.component("downloadExcel", JsonExcel);

new Vue({
  mode: 'history',
  router,
  store,
  render: h => h(App)
}).$mount('#app')
