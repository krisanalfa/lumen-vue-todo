import Vue from 'vue'
import store from '@/store'
import router from '@/router'
import VueResource from 'vue-resource'

Vue.use(VueResource)

Vue.http.options.root = 'http://localhost:9000'
Vue.http.headers.common['Accept'] = 'application/json'
Vue.http.headers.common['Content-Type'] = 'application/json'

Vue.http.interceptors.push((request, next) => {
  // set token
  store.state.token && request.headers.set('Authorization', `Bearer ${store.state.token}`)

  // continue to next interceptor
  next((response) => {
    if (response.status === 401) {
      router.push({name: 'logout'})
    }
  })
})

export default Vue.http
