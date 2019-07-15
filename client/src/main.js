import '../node_modules/bootstrap/dist/css/bootstrap.css'
import store from './store'
import router from './router'
import Vue from 'vue'
import App from './App'
import Toastr from 'vue-toastr'

Vue.use(router)
Vue.use(Toastr)
Vue.config.productionTip = false

new Vue({
  store,
  router,
  render: h => h(App)
}).$mount('#app')
