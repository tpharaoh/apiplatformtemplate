import axios from '../../../interceptor'

export const state = () => ({
  item: {},
  items: [],
  errors: {}
})

export const mutations = {
  SET_ITEM(state, item) {
    state.item = item
  },
  SET_ITEMS(state, items) {
    state.items = items
  },
  UPDATE_ITEM(state, item) {
    state.item = Object.assign({}, state.item, item)
  },
  SET_ERRORS(state, errors) {
    state.errors = errors
  },
  RESET_STATE(state) {
    Object.assign(state, {
      item: {},
      items: [],
      errors: {}
    })
  }
}

export const getters = {
  item: state => state.item,
  items: state => state.items,
  errors: state => state.errors
}

export const actions = {
  resetState({ commit }) {
    commit('RESET_STATE')
  },
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
  getItems({ commit }) {
    const url = process.env.VUE_APP_API_URL + '/books'

    return axios
      .get(url)
      .then(response => response.data)
      .then(data => {
        commit('SET_ITEMS', data['hydra:member'])
      })
  },
  getItem({ commit }, id) {
    const url = process.env.VUE_APP_API_URL + '/books/' + id

    return axios
      .get(url)
      .then(response => response.data)
      .then(data => {
        commit('SET_ITEM', data)
      })
  },
  create({ state, dispatch }) {
    const url = process.env.VUE_APP_API_URL + '/books'

    return axios.post(url, state.item).catch(e => {
      dispatch('processErrors', e.response.data)
    })
  },
  update({ state, dispatch }) {
    const url = process.env.VUE_APP_API_URL + '/books/' + state.item.id

    return axios.put(url, state.item).catch(e => {
      dispatch('processErrors', e.response.data)
    })
  },
  remove({ state }, id) {
    const url = process.env.VUE_APP_API_URL + '/books/' + id

    return axios.delete(url, state.item)
  },
  download({ state, dispatch }) {
    const url = process.env.VUE_APP_API_URL + '/book_update_download_counts'

    return axios.put(url, state.item).catch(e => {
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
