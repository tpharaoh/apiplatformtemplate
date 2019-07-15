import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '../store'
import SignIn from '../pages/SignIn'
import SignUp from '../pages/SignUp'
import MainSlot from '../components/MainSlot'

import bookRoutes from './book'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/signin',
      name: 'SignIn',
      component: SignIn,
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/signup',
      name: 'SignUp',
      component: SignUp,
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/',
      component: MainSlot,
      children: [...bookRoutes],
      meta: {
        requiresAuth: true
      }
    }
  ]
})

router.beforeEach((to, from, next) => {
  let token = store.getters['auth/jwtDecoded'] || null
  let authorized = token && token.exp > Date.now() / 1000

  if (authorized) {
    if (to.matched.some(record => !record.meta.requiresAuth)) {
      next({ name: 'BookList' })
    }
  } else {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      next({ name: 'SignIn' })
    }
  }

  next()
})

export default router
