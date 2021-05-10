<template>
  <div class="flex flex-wrap w-full justify-center pt-8" >
    <img :src="`/storage/${image.url}`" alt="" v-for="(image,index) in pictures" :key="image.id" class="w-3/10 h-60 object-cover mx-2 my-4 rounded-md shadow-xl cursor-pointer" @click="openModal(index)">
  </div>
</template>

<script>
export default {
  props: ['props'],
  data(){
    return{
        pictures: []
    }
  },
  beforeMount(){
    axios.get(`/api/user_pictures?user_id=${this.props.userProfile.id}`)
    .then(resp => this.pictures = resp.data)
    .catch(error => console.log(error.response))
  },
  methods: {
    openModal(pictureIndex){
      this.$emit('openModal', {
        isModalOpen: true,
        pictures: this.pictures,
        currentPicture: pictureIndex
      })
    }
  }
}
</script>

<style>
 
</style>