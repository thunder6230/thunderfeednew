<template>
  <div class="w-1/5">
    <div class="w-full">
        <a :href="`/profile/${props.user.username}`"><img :src="`/storage/${props.user.pictures[user.pictures.length - 1].url}`" alt="" class="w-full object-cover"></a>
    </div>
    <div class="text-center">
      <a :href="`/profile/${props.user.username}`" class="font-medium">{{props.user.name}}</a>
    </div>
    <div v-if="props.userLoggedIn">
      <button @click="addFriend" v-if="!isMyfriend && !isPending"><i class="fas fa-user-plus"></i> Add Friend</button>
      <button @click="deleteFriend" v-if="isMyfriend"><i class="fas fa-user-minus"></i> Remove Friend</button>
      <button @click="acceptFriend" v-if="isPending"><i class="fas fa-user-plus"></i> Accept Friend</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['props'],
  data(){
    return {
      isMyfriend: false,
      isPending: false,
      csrf: document.head.querySelector('meta[name="csrf-token"]').content
    }
  },
  mounted(){
    this.checkFriends()
  },
  updated() {
    this.checkFriends()
  },
  methods: {
    addFriend(){
      const params = {
        '_token': this.csrf,
        'user_id': this.props.user.id
      }
        axios.post(`/api/addfriend`, params)
        .then(resp => this.$emit('addedFriend', resp.data))
        .catch(error => console.log(error.response))
    },
    acceptFriend(){
      const params = {
        '_token': this.csrf,
        'user_id': this.props.user.id
      }
      axios.post(`/api/acceptfriend`, params)
        .then(resp =>  {
          this.isPending = false
          this.$emit('acceptedFriend', resp.data)
          
        })
        .catch(error => console.log(error.response))
    },
    deleteFriend(){
      const params = {
        '_token': this.csrf,
        '_method': 'DELETE',
        'user_id': this.props.user.id
      }
      axios.post(`/api/deletefriend`, params)
        .then(resp => {
          this.isMyfriend = false
          this.$emit('deleteFriend', resp.data)
        })
        .catch(error => console.log(error.response))
    },
    checkIfFriend(){
      this.props.myFriends.forEach(
        friendId => {
          if(friendId == this.props.user.id){
            this.isMyfriend = true
            return
          }
        }) 
    },
    checkFriendOf(){
      this.props.pending.forEach(
        friendId => {
          if(friendId == this.props.user.id){
            this.isPending = true
            return
          }
        }) 
    },
    checkFriends(){
      this.checkIfFriend()
      this.checkFriendOf()
    }
  }
}
</script>

<style>

</style>