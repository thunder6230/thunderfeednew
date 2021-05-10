<template>
  <div class="fixed top-0 left-0 w-screen h-screen bg-black bg-opacity-70 flex justify-center items-center" data-modal="true" :class="{'z-50' : props.isModalOpen}" @click.stop="closeModal">
    <div class="h-3/4 flex justify-center items-center max-w-screen-xl" >
        <div class="text-gray-400 text-xl hover:text-white hover:text-2xl transition-all cursor-pointer" @click="prevPicture"><i class="fas fa-chevron-left py-16 px-4"></i></div>
        <img :src="`/storage/${pictures[currentPicture].url}`" alt="" class="inset-y-2/4 inset-x-2/4 h-full mx-1 object-cover">
        <div class="text-gray-400 text-xl hover:text-white hover:text-2xl transition-all cursor-pointer"><i class="fas fa-chevron-right py-16 px-4" @click="nextPicture"></i></div>
    </div>
  </div>
</template>

<script>
export default {
    props: ['props'],
    data(){
        return {
            currentPicture: 0,
            pictures: []
        }
    },
    beforeMount(){
        this.currentPicture = this.props.currentPicture
        this.pictures = this.props.pictures
    },
    methods: {
        prevPicture(){
            this.currentPicture = this.currentPicture -1
            if(this.currentPicture < 0) {
                this.currentPicture = this.pictures.length -1
            }
            console.log(this.currentPicture)
        },
        nextPicture(){
            this.currentPicture = this.currentPicture + 1
            if(this.currentPicture == this.pictures.length) {
                this.currentPicture = 0
            }
            console.log(this.currentPicture)
        },
        closeModal(event){
            if(event.target.getAttribute("data-modal")){
                this.$emit('closeModal', false)
            }
        }
    }
}
</script>

<style>
body {
    overflow-x: hidden;
}
</style>