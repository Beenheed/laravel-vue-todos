import axios from 'axios'
import qs from 'qs'

axios.defaults.baseURL = 'http://api.todos.local/api/v1/'
axios.defaults.paramsSerializer = function (params) {
  return qs.stringify(params, {arrayFormat: 'indices'})
}

const actions = {
  /*
   * todo related actions
   */
  getTodos (context) {
    return new Promise((resolve, reject) => {
      const url = 'todos'
      axios.get(url).then(response => {
        context.commit('SET_TODOS', response.data)
        resolve()
      }).catch((e) => {
        reject(e)
      })
    })
  },
  createTodo (context, todo) {
    return new Promise((resolve, reject) => {
      const url = 'todos'
      axios.post(url, todo).then(response => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  },
  updateTodo (context, todo) {
    return new Promise((resolve, reject) => {
      const url = 'todos/' + todo.id
      axios.put(url, todo).then(response => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  },
  deleteTodo (context, todoId) {
    return new Promise((resolve, reject) => {
      const url = 'todos/' + todoId
      axios.delete(url).then(response => {
        resolve(response.data)
      }).catch((e) => {
        reject(e.response.data)
      })
    })
  }
}

export default actions

