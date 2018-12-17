import Vue from 'vue'
// Bootstrapview
import BootstrapVue from 'bootstrap-vue'
// sweetalert for fancy stuff
import VueSweetalert2 from 'vue-sweetalert2'

import router from './router'
import store from './store'

import App from './App.vue'

// Resource logic
Vue.use(BootstrapVue)
Vue.use(VueSweetalert2)


new Vue({
  el: '#app',
  router: router,
  store: store,
  render: h => h(App)
})