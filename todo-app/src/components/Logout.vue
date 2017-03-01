<template lang="html">
</template>

<script>
import { LOGOUT } from '@/store/mutation-types'

export default {
  name: 'Logout',

  mounted () {
    this.$http.get('logout').then(
      this.logout, this.logout
    )
  },

  methods: {
    logout () {
      this.$store.commit(LOGOUT)
      this.$router.push({name: 'login'})
    }
  }
}
</script>
