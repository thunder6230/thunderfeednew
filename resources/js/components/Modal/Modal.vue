<template>
  <div class="fixed top-0 left-0 w-screen h-screen bg-opacity-50 flex justify-center items-center" data-modal="true" :class="{'z-50' : props.isModalOpen}" @click="closeModal">
    <div class="h-screen flex justify-center items-center w-screen" >
        <div class="h-full flex justify-between items-center w-8/12 relative bg-black" :class="{'w-full': isFullScreenOn }">
            <div class="text-gray-400 text-xl hover:text-white hover:text-2xl transition-all cursor-pointer" @click="prevPicture"><i class="fas fa-chevron-left py-16 px-4"></i></div>
            <img :src="`/storage/${pictures[currentPicture].url}`" alt="" class="">
            <div class="text-gray-400 text-xl hover:text-white hover:text-2xl transition-all cursor-pointer" @click="nextPicture"><i class="fas fa-chevron-right py-16 px-4"></i></div>
            <button class="text-white absolute top-2 left-2 text-xl hover:text-white hover:text-2xl transition-all cursor-pointer" ><i class="fa fa-times" @click="closeModal" data-modal="true"></i></button>
            <button class="text-white absolute top-2 right-2 text-xl hover:text-white hover:text-2xl transition-all cursor-pointer" ><i class="fa fa-arrows-alt" @click="isFullScreenOn = !isFullScreenOn"></i></button>
        </div>
        <div class="px-4 w-4/12 h-screen  bg-gray-50" :class="{hidden: isFullScreenOn}">
            <div class="flex justify-around py-2 text-blue-700">
                <p>{{ props.pictures[currentPicture].likes.length }} {{pluralize('Like', props.pictures[currentPicture].length)}}</p>
                <p>{{ props.pictures[currentPicture].comments.length}} {{pluralize('Comment', props.pictures[currentPicture].comments.length)}}</p>
            </div>
            <div v-if="props.user" class="flex items-center py-2 border-t border-blue-200 ">
                    
                <button v-if="isLikedByMe == false" type="button" 
                class="flex-1 text-blue-700 font-medium" @click="like">

                <i class="fas fa-thumbs-up"></i> Like</button>
                <button v-else type="button" 
                class="flex-1 text-blue-700 font-medium text-lg" @click="unlike">
                <i class="fas fa-thumbs-up transform rotate-180 pb-1 text-lg"></i> Unlike</button>

                <p class="flex-1 text-center text-blue-700 font-medium text-lg cursor-pointer" @click="writeComment" data-role="newComment"><i class="far fa-comment-dots"></i> Write Comment</p>
            </div>
            <picture-comments :props="{
                comments: props.pictures[currentPicture].comments,
                user: props.user,
                csrf: props.csrf,
                auth: props.auth,
                pictureId: props.pictures[currentPicture].id,
                //isMouseEnter: isMouseEnter,
                //isWriteComment: isWriteComment,
            }" @removeComment="removeComment"/>
        </div>
    </div>
  </div>
</template>

<script>
import PictureComments from '../PostsApp/PictureComments.vue'
export default {
    props: ['props'],
    data(){
    
        return {
            currentPicture: 0,
            pictures: [],
            isLikedByMe: false,
            myLikeId: null,
            isMyPicture: false,
            isFullScreenOn: false,
        }
    },
    beforeMount(){
        this.currentPicture = this.props.currentPicture
        this.pictures = this.props.pictures
        document.body.style.overflow = "hidden"

        if(this.props.user){
            this.pictures[this.currentPicture].likes.forEach(like => {
                if(like.user_liked_id == this.props.user.id){
                    this.isLikedByMe = true
                    this.myLikeId = like.id
                    return
                }
            })
            this.pictures[this.currentPicture].user_id == this.props.user.id ? this.isMyPicture = true : null
        }
    },
    destroyed(){
        document.body.style.overflow = "auto"
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
            console.log(event.target)
            if(event.target.getAttribute("data-modal")){
                console.log('click2')
                this.$emit('closeModal', false)
            }
        },
         pluralize(word, amount){
            return amount > 1 || amount == 0 ? `${word}s` : word
        },
        like(){
            const params = {
                '_token': this.props.csrf,
                'id': this.pictures[this.currentPicture].id
            }

            axios.post(`/api/pictures/like`, params)
            .then(resp => {
                this.isLikedByMe = true
                this.myLikeId = resp.data.id
                this.pictures[this.currentPicture].likes.push(resp.data)
            })
            .catch(err => console.log(err))
        },
        unlike(){
            axios.delete(`/api/like/${this.myLikeId}/unlike`)
            .then(resp => {
                if (resp.status == 200){
                    this.pictures[this.currentPicture].likes = this.pictures[this.currentPicture].likes.filter(like => like.id != this.myLikeId)
                    this.isLikedByMe = false
                    this.myLikeId = null
                }
                return
            })
            .catch(err => console.log(err))
        },
        writeComment(){

        },
        removeComment(){
            
        }
    },
    components: {PictureComments}
}
</script>

<style>
</style>