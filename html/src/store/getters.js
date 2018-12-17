const getters = {
  getTodos: state => state.todos,
  getLoadingState: state => state.isLoading || false,
}

export default getters
