export default {
  authUser: state => {
    return state.user
  },

  authToken: state => {
    return state.token
  },

  allTasks: state => {
    return state.tasks
  },

  activeTasks: state => {
    return state.tasks.filter(todo => !todo.done)
  },

  completedTasks: state => {
    return state.tasks.filter(todo => todo.done)
  }
}
