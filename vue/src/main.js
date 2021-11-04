import 'core-js/stable'
import Vue from 'vue'
import App from './App'
import router from './router'
import CoreuiVue from '@coreui/vue'
import { iconsSet as icons } from './assets/icons/icons.js'
import store from './store'
import vSelect from 'vue-select'
import _ from 'lodash'

Vue.prototype.$apiAdress = 'http://127.0.0.1:8000'
Vue.config.performance = true
Vue.use(CoreuiVue)
Vue.component('v-select', vSelect)

new Vue({
  el: '#app',
  router,
  store,  
  icons,
  template: '<App/>',
  components: {
    App
  },
})
