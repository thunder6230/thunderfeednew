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
    axios.get(`/api/user_pictures?user_id=${this.props.profile.id}`)
    .then(resp => this.pictures = resp.data)
    .catch(error => console.log(error.response))
  },
  mounted(){
     if(this.props.pictureId > 0){
       setTimeout(() => {
         this.pictures.forEach((picture,index) => {
           console.log('yes')
           console.log(picture)
           if(picture.id == this.props.pictureId){
             return this.openModal(index)
           }
         })
       }, 500);
     }
  },
  methods: {
    openModal(pictureIndex){
      const props =  {
        isModalOpen: true,
        pictures: this.pictures,
        currentPicture: pictureIndex,
        user: this.props.user,
        csrf: this.props.csrf,
        auth: this.props.auth,
      }
      this.$emit('openModal', props)
    }
  }
}
</script>

<style>
 
</style>