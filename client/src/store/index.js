import Vue from 'vue'
import Vuex from 'vuex'

import general from './modules/general/'
import auth from './modules/auth/'
import book from './modules/book/'
import user from './modules/user/'

Vue.use(Vuex)

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  modules: {
    general,
    auth,
    book,
    user
  }
})
