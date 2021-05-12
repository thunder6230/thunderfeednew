<template>
  <div class="flex width-full flex-wrap">
      <User v-for="user in users" :key="user.id" :props="{
        user: user,
        userLoggedIn: userLoggedIn,
        pending: pending,
        myFriends: myFriends
      }" @addedFriend="addFriend"
        @acceptedFriend="acceptedFriend"
        @deleteFriend="deleteFriend"/>
  </div>
</template>

<script>
import User from './User.vue'
export default {
  props:['user'],
  data(){
    return {
      users: [],
      userLoggedIn: null,
      myFriends: [],
      pending: [],
    }
  },
  created(){
    this.userLoggedIn = JSON.parse(this.user)
  },
  mounted(){
    this.getUsers()
    this.initialize()
  },
  methods:{
    addFriend(id){
      this.myFriends.push(id);
    },
    acceptedFriend(id){

      this.pending = this.pending.filter(pendingId => pendingId != id)
      this.addFriend(id)
    },
    deleteFriend(id){
      this.myFriends = this.myFriends.filter(friendId => friendId != id)
    },
    createMyFriends(){
      this.userLoggedIn.friends.forEach(friend => this.myFriends.push(friend.id))
    },
    getUsers(){
      axios.get('/api/allusers').then(resp => this.users = resp.data)
      .catch(error => console.log(error.response))
    },
    createPending(){
    this.userLoggedIn.friend_of.forEach(friend => 
      friend.pivot.accepted_at != null ? this.myFriends.push(friend.id) : this.pending.push(friend.id))
    },
    initialize(){
    this.createMyFriends()
    this.createPending()  
    }
  },
  components: { User }
}
</script>

<style>

</style>