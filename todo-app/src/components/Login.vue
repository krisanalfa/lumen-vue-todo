<template lang="html">
  <form @submit.prevent="login">
    <section class="todoapp">
      <header class="header">
        <h1>login</h1>
      </header>
      <div class="main">
        <input type="email" class="text" placeholder="Email" v-model="credential.email" autofocus @keyup.enter="login">
        <input type="password" class="text" placeholder="Password" v-model="credential.password" @keyup.enter="login">
      </div>
    </section>

    <button type="submit">LOGIN</button>
  </form>
</template>

<style scoped="true" lang="scss">
button[type="submit"] {
  margin: 0 auto;
  display: block;
  font-size: 18px;
  cursor: pointer;
  font-weight: 600;
  background: #fff;
  padding: 18px 32px;
  border: 1px solid #999;
}

.text {
  width: 100%;
	padding: 16px;
	border: none;
	font-size: 24px;
  position: relative;
	line-height: 1.4em;
	border: 1px solid #999;
	box-sizing: border-box;
	font-smoothing: antialiased;
  background: rgba(0, 0, 0, 0.003);

  &[type="email"] {
    border-bottom: none;
  }

  &:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 10000px white inset;
  }
}
</style>

<script>
import { LOGIN, FETCH_TASKS } from '@/store/mutation-types'

export default {
  name: 'Login',

  data () {
    return {
      credential: {
        email: '',
        password: ''
      }
    }
  },

  methods: {
    login () {
      this.$http.post('login', this.credential)
      .then(({ data }) => {
        this.$store.commit(LOGIN, data.data)
        this.$store.dispatch(FETCH_TASKS)
        this.$router.push({name: 'root'})
      }, ({ data }) => {
        data && alert(data.message)
      })
    }
  }
}
</script>
