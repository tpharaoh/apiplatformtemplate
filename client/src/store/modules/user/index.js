import axios from '../../../interceptor'

export const state = () => ({
  item: {},
  errors: {}
})

export const mutations = {
  SET_ITEM(state, item) {
    state.item = item
  },
  UPDATE_ITEM(state, item) {
    state.item = Object.assign({}, state.item, item)
  },
  SET_ERRORS(state, errors) {
    state.errors = errors
  }
}

export const getters = {
  item: state => state.item,
  errors: state => state.errors
}

export const actions = {
  processErrors({ commit }, data) {
    if (data.violations) {
      let errors = {}

      data.violations.map(violation => {
        Object.assign(errors, { [violation.propertyPath]: violation.message })
      })

      commit('SET_ERRORS', errors)
    }

    throw data
  },
  register({ state, commit, dispatch }) {
    commit('SET_ERRORS', {})

    const url = process.env.VUE_APP_API_URL + '/register'

    return axios.post(url, state.item).catch(e => {
      dispatch('processErrors', e.response.data)
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
