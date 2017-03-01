import api from '@/api'
import * as TYPES from './mutation-types'

export default {
  [TYPES.FETCH_TASKS] ({ state }) {
    api.get('task').then(({ data }) => {
      state.tasks = data.data
    }, (error) => {
      console.log(error)
    })
  },

  [TYPES.CREATE_TASK] ({ state }, task) {
    task.user_id = state.user.id

    api.post('task', task).then(({ data }) => {
      state.tasks.push(data.data)
    }, (error) => {
      console.log(error)
    })
  },

  [TYPES.UPDATE_TASK] ({ state }, task) {
    api.patch(`task/${task.id}`, task).then(({ data }) => {
      // n00p
    }, (error) => {
      console.log(error)
    })
  },

  [TYPES.DELETE_TASK] ({ state }, task) {
    api.delete(`task/${task.id}`, task).then(({ data }) => {
      state.tasks.splice(
        state.tasks.indexOf(task),
        1
      )
    }, (error) => {
      console.log(error)
    })
  },

  [TYPES.CLEAR_COMPLETED_TASKS] ({ state, dispatch }) {
    state.tasks.filter(todo => todo.done).forEach(task => {
      dispatch(TYPES.DELETE_TASK, task)
    })
  }
}
