import Vue from 'vue'

const mutations = {
  SET_LOADING_STATE: (state, loading) => {
    Vue.set(state, 'isLoading', loading)
  },
  SET_TODOS (state, todos) {
    Vue.set(state, 'todos', todos)
  }
}

export default mutations
