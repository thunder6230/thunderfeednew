<template>
  <div class="flex flex-col w-full items-center justify-center">
      <h1>Profile Pictures</h1>
      <div class="flex flex-wrap w-full justify-center pt-8">
        <img :src="`/storage/${image.url}`" alt="" v-for="(image,index) in profilePictures" :key="image.id" class="w-3/10 h-60 object-cover mx-2 my-4 rounded-md shadow-xl cursor-pointer" @click="openModal(index, profilePictures)">
      </div>
      <h1>Post Pictures</h1>
      <div class="flex flex-wrap w-full justify-center pt-8">
        <img :src="`/storage/${image.url}`" alt="" v-for="(image,index) in pictures" :key="image.id" class="w-3/10 h-60 object-cover mx-2 my-4 rounded-md shadow-xl cursor-pointer" @click="openModal(index, pictures)">

      </div>
  </div>
</template>

<script>
export default {
  props: ['props'],
  data(){
    return{
        pictures: [],
        profilePictures: [],
        isPicturePost: false
    }
  },
  beforeMount(){
    axios.get(`/api/user_pictures?user_id=${this.props.profile.id}`)
    .then(resp => {
        resp.data.forEach(picture => {
          console.log(picture)
          if(picture.pictureable_type == "App\\Models\\User"){
            this.profilePictures.push(picture)
          }else{
            this.pictures.push(picture)
            }
        })

    })
    .catch(error => console.log(error.response))
  },
  mounted(){
     if(this.props.pictureId > 0){
       setTimeout(() => {
         this.checkIfPostPicture(this.pictures, true)
         if(!this.isPicturePost){
           this.checkIfPostPicture(this.profilePictures, false)
         }
       }, 500);
     }
  },
  methods: {
    openModal(pictureIndex, pictures){
      const props =  {
        isModalOpen: true,
        pictures: pictures,
        currentPicture: pictureIndex,
        user: this.props.user,
        csrf: this.props.csrf,
        auth: this.props.auth,
      }
      this.$emit('openModal', props)
    },
    checkIfPostPicture(pictures, isPost){
      pictures.forEach((picture,index) => {
        console.log(picture)
           if(picture.id == this.props.pictureId){
             this.isPicturePost = isPost
             return this.openModal(index, pictures)
           }
         })
    }
  }
}
</script>

<style>
 
</style>