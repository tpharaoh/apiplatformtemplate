import jwtDecode from 'jwt-decode'
import * as types from './mutation_types'
import router from '../../../router'
import axios from '../../../interceptor'

const actions = {
  login({ commit }, data) {
    commit(types.AUTH_ERROR_CHANGE, null)

    const url = process.env.VUE_APP_API_URL + '/login'

    return axios
      .post(url, data)
      .then(response => {
        commit(types.AUTH_UPDATE_TOKEN, response.data)
      })
      .catch(() => {
        commit(types.AUTH_ERROR_CHANGE, 'Incorrect username or password')
      })
  },
  logout({ commit }) {
    commit(types.AUTH_RESET)
    router.push({ name: 'SignIn' })
  }
}

function initialState() {
  return {
    token: localStorage.getItem('token'),
    mercureToken: localStorage.getItem('mercureToken'),
    error: null
  }
}

const state = initialState()

const getters = {
  jwtDecoded: state => {
    if (state.token) {
      return jwtDecode(state.token)
    }
  },
  error: state => state.error,
  mercureToken: state => state.mercureToken
}

const mutations = {
  [types.AUTH_UPDATE_TOKEN](state, data) {
    localStorage.setItem('token', data.token)
    localStorage.setItem('mercureToken', data.mercureToken)

    state.token = data.token
    state.mercureToken = data.mercureToken
  },
  [types.AUTH_ERROR_CHANGE](state, error) {
    state.error = error
  },
  [types.AUTH_RESET](state) {
    localStorage.removeItem('token')
    localStorage.removeItem('mercureToken')

    const s = initialState()
    Object.keys(s).forEach(key => {
      state[key] = s[key]
    })
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
