import localStorage from 'store'

export default {
  user: localStorage.get('user') || {},
  tasks: [],
  token: localStorage.get('token') || ''
}
