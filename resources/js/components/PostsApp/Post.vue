<template>
<div ref="post"
    @mouseenter="handleMouseEnter"
    @mouseleave="handleMouseLeave"
    class="rounded-xl mb-4 p-4 bg-white border border-blue-200 shadow-lg">
    <div class="relative flex">
            <a :href="`/profile/${props.post.user.username}`" class="w-10 mr-2">
                <img :src="`/storage/${props.post.user.pictures[props.post.user.pictures.length - 1].url}`"
                    :alt="`${props.post.user.username}`" class="rounded-full w-10 h-10 object-cover">
            </a>
            <div class="flex flex-col justify-end">
                <div class="text-lg leading-3 pb-0.5 text-lg leading-3 pb-0.5">
                    <a :href="`/profile/${props.post.user.username}`"
                            class="font-medium">{{props.post.user.name}}
                    </a>
                    <span v-if="props.post.user_to != null"> to 
                        <a :href="`/profile/${props.post.user_to.username}`" class="font-medium">{{props.post.user_to.name}}</a>
                    </span>
                </div>
                <vue-moments-ago prefix="" suffix="ago" v-bind:date="props.post.created_at" lang="en" class="text-gray-500 inline-block"></vue-moments-ago>
            </div>
        <div class="absolute right-0 top-0" v-if="isMouseEnter && isMyPost == true">
            <button type="button" @click="editPost"><i class="far fa-edit text-blue-700"></i></button>
            <button type="button" @click="confirmDelete"><i class="far fa-times-circle text-red-500"></i></button>
        </div>
    </div>
    <div class="px-4">
        <p class="px-1" v-if="!isEditOn" ref="postBody">{{postBody}}</p>
        <form @submit.prevent="submitEdit" v-if="isEditOn">
            <input type="text" v-model="newBody" class="w-full border-0 px-1" ref="postInput">
        </form>
    </div>
    <div v-if="props.post.pictures.length > 0">
        <img :src="`/storage/${picture.url}`" alt="" class="rounded"  v-for="(picture,index) in props.post.pictures" :key="index" @click="openPostPictureModal(index)">
    </div>
    <modal @closeModal="isOpenPostPicture = false" v-if="isOpenPostPicture"
        :props="{
            pictures: props.post.pictures,
            currentPicture: clickedPictureIndex,
            isModalOpen: isOpenPostPicture,
            user: props.user,
            csrf: props.csrf,
            auth: props.auth,
        }"></modal>
    <div class="px-4">
        <div class="flex justify-around py-2">
            <p>{{ props.post.likes.length }} {{pluralize('Like', props.post.likes.length)}}</p>
            <p>{{ props.post.comments.length}} {{pluralize('Comment', props.post.comments.length)}}</p>
        </div>
        <div class="flex items-center py-2 border-t border-blue-200 ">
                
            <button v-if="isLikedByMe == false" type="button" 
            class="flex-1 text-blue-700 font-medium" @click="like">

            <i class="fas fa-thumbs-up"></i> Like</button>
            <button v-else type="button" 
            class="flex-1 text-blue-700 font-medium text-lg" @click="unlike">
            <i class="fas fa-thumbs-up transform rotate-180 pb-1 text-lg"></i> Unlike</button>

            <p class="flex-1 text-center text-blue-700 font-medium text-lg cursor-pointer" @click="writeComment" data-role="newComment"><i class="far fa-comment-dots"></i> Write Comment</p>
        </div>
        <Comments :props="{
            postId: props.post.id,
            comments: props.post.comments,
            user: props.user,
            csrf: props.csrf,
            auth: props.auth,
            isMouseEnter: isMouseEnter,
            isWriteComment: isWriteComment,
        }" @removeComment="removeComment" @openLogin="$emit('openLogin')"/>
    </div>

</div>
</template>

<script>

import VueMomentsAgo from 'vue-moments-ago'
import Modal from '../Modal/Modal.vue'
import Comments from './Comments.vue'
export default {
    props:['props'],
    data(){
        return {
            isLikedByMe: false,
            myLikeId: null,
            isCommentsOpen: false,
            isMyPost: false,
            isMouseEnter: false,
            isWriteComment: false,
            isEditOn:false,
            postBody: this.props.post.body,
            newBody: "",
            isOpenPostPicture: false,
            clickedPictureIndex: 0
        }
    },
    mounted(){
    },
    updated(){
         document.addEventListener('click', (e) => {
            e.target.getAttribute('data-role') != "newComment" ? this.isWriteComment = false : null
        })
    },
    methods: {
        pluralize(word, amount){
            return amount > 1 || amount == 0 ? `${word}s` : word
        },
        showComments(){
            this.isCommentsOpen = !this.isCommentsOpen
        },
        confirmDelete(){
            if(!confirm('Are you sure you want to delete?')){
                return
            }
            this.deletePost()
        },
        deletePost(){
            axios.delete('/api/posts/' + this.props.post.id)
            .then(resp => resp.status == 200 ? this.$refs.post.remove() : null)
            .catch(err => console.log(err))
        },
        like(){
            if(!this.props.auth){
                return this.$emit('openLogin')
            }
            const params = {
                'post_id': this.props.post.id,
                '_token': this.props.csrf
            }
            axios.post('/api/posts/like', params)
            .then(resp => {
                if(resp.status == 200){
                    this.isLikedByMe = true
                    this.myLikeId = resp.data.id
                    this.props.post.likes.push(resp.data)
                }
            })
            .catch(err => console.log(err))
        },
        unlike(){
            axios.delete(`/api/like/${this.myLikeId}/unlike`)
            .then(resp => {
                if (resp.status == 200){
                    this.props.post.likes = this.props.post.likes.filter(like => like.id != this.myLikeId)
                    this.isLikedByMe = false
                    this.myLikeId = null
                }
                return
            })
            .catch(err => console.log(err))
        },
        handleMouseEnter(){
            this.isMouseEnter = true
        },
        handleMouseLeave(){
            this.isMouseEnter = false
        },
        writeComment(){
            console.log('fityma')
            this.isWriteComment = true
        },
        removeComment(id){
            let comments = [...this.props.post.comments]
            comments = comments.filter(comment => comment.id != id)
            this.props.post.comments = comments
        },
        editPost(){
            this.isEditOn = !this.isEditOn
            setTimeout(() => {
                this.$refs.postInput.focus()
            }, 50);
        },
        submitEdit(){
            const params = {
                '_token': this.props.csrf,
                'new_body': this.newBody,
                'post_id': this.props.post.id
            }
            axios.post(`/api/posts/update`, params)
            .then(resp => {
                console.log(resp.data)
                if(resp.data.success){
                    alert('Something went wrong!')
                }

                this.postBody = this.newBody
                this.isEditOn = false
                this.newBody = ""
            })
            .catch(error => console.log(error.response))
        },
        openPostPictureModal(index){
           this.clickedPictureIndex = index
           this.isOpenPostPicture = true
        }
    },
    mounted(){
        
        if(this.props.user){
            this.props.post.likes.forEach(like => {
                if(like.user_liked_id == this.props.user.id){
                    this.isLikedByMe = true
                    this.myLikeId = like.id
                    return
                }
            })
            this.props.post.user_id == this.props.user.id ? this.isMyPost = true : null
        }
    },
    
    components: {VueMomentsAgo, Comments}
}
</script>

<style>

</style>