import Vue from 'vue'
import store from '@/store'
import Router from 'vue-router'
import Todo from '@/components/Todo'
import Login from '@/components/Login'
import Logout from '@/components/Logout'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login,
      beforeEnter (from, to, next) {
        next(store.state.token === '' ? true : {name: 'root'})
      },
      meta: {
        guarded: false
      }
    },
    {
      path: '/logout',
      name: 'logout',
      component: Logout,
      meta: {
        guarded: true
      }
    },
    {
      path: '/',
      name: 'root',
      component: Todo,
      meta: {
        guarded: true
      }
    },
    {
      path: '/all',
      name: 'all',
      component: Todo,
      meta: {
        guarded: true
      }
    },
    {
      path: '/active',
      name: 'active',
      component: Todo,
      meta: {
        guarded: true
      }
    },
    {
      path: '/completed',
      name: 'completed',
      component: Todo,
      meta: {
        guarded: true
      }
    }
  ]
})

router.beforeEach((to, from, next) => {
  next(
    (to.meta.guarded && store.state.token === '') ? {name: 'login'} : true
  )
})

export default router
