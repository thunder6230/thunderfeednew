<template>
  <div class="flex width-full flex-wrap">
      <User v-for="user in users" :key="user.id" :props="{
        user: user,
        userLoggedIn: userLoggedIn
      }"/>
  </div>
</template>

<script>
import User from './User.vue'
export default {
  props:['user'],
  data(){
    return {
      users: [],
      userLoggedIn: null
    }
  },
  created(){
    this.userLoggedIn = JSON.parse(this.user)
  },
  mounted(){
    axios.get('/api/allusers').then(resp => this.users= resp.data)
    .catch(error => console.log(error.response))
  },
  components: { User }
}
</script>

<style>

</style>