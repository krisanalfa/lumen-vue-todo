import { omit } from 'lodash'
import localStorage from 'store'
import { LOGIN, LOGOUT } from './mutation-types'

export default {
  [LOGIN] (state, user) {
    state.token = user.api_token
    state.user = omit(user, ['api_token'])

    localStorage.set('token', state.token)
    localStorage.set('user', state.user)
  },

  [LOGOUT] (state) {
    state.token = ''
    state.user = {}

    localStorage.remove('token')
    localStorage.remove('user')
  }
}
