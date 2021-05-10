<template>
  <div class="w-1/5">
    <div class="w-full">
        <img :src="`/storage/${props.user.picture.url}`" alt="" class="w-full object-cover">
    </div>
    <div class="text-center">
      <p class="font-medium">{{props.user.name}}</p>
    </div>
    <div v-if="props.userLoggedIn">
      <button @click="addFriend"><i class="fas fa-user-plus"></i> Add Friend</button>
      <button @click="removeFriend"><i class="fas fa-user-minus"></i> Remove Friend</button>
      <button @click="acceptFriend"><i class="fas fa-user-plus"></i> Accept Friend</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['props'],
  data(){
    return {

    }
  },
  mounted(){

  },
  methods: {
    addFriend(){},
    acceptFriend(){},
    removeFriend(){}
  }
}
</script>

<style>

</style>