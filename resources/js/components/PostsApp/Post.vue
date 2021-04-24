<template>
<div ref="post" class="rounded-xl mb-4 p-4 bg-white border border-blue-200 shadow-lg">
    <div class="relative flex">
            <a :href="`/profile/${props.post.user.id}`" class="w-10 mr-2">
                <img :src="`/storage/${props.post.user.profile_picture}`"
                    :alt="`${props.post.user.id}`" class="rounded-full w-10">
            </a>
            <div class="flex flex-col justify-end">
                <a :href="`/profile/${props.post.user.id}`" class="font-medium text-lg leading-3 inline-block">{{props.post.user.name}}</a>
                <vue-moments-ago suffix="ago" v-bind:date="props.post.created_at" lang="en" class="text-gray-500 inline-block"></vue-moments-ago>
            </div>
        <div class="absolute right-0 top-0">
            <button type="button" @click="deletePost"><i class="far fa-times-circle text-red-500"></i></button>
        </div>
    </div>
    <div class="px-4">
        <p class="pb-1">{{props.post.body}}</p>
    </div>
        <img :src="`/storage/${props.post.image_path}`" alt="" class="rounded">
    <div class="px-4">
        <div class="flex justify-around border-b border-gray-200 py-2">
            <p>{{ props.post.likes.length }} {{pluralize('Like', props.post.likes.length)}}</p>
            <p>{{ props.post.post_comments.length}} {{pluralize('Comment', props.post.post_comments.length)}}</p>
        </div>
        <div v-if="this.props.user" class="flex items-center py-2">
                
            <button v-if="isLikedByMe == false" type="button" 
            class="flex-1 text-blue-700 font-medium" @click="like">

            <i class="fas fa-thumbs-up"></i> Like</button>
            <button v-else type="button" 
            class="flex-1 text-blue-700 font-medium" @click="unlike">
            <i class="fas fa-thumbs-up transform rotate-180 pb-1"></i> Unlike</button>

            <a :href="`#comment_body${props.post.id}`" class="flex-1 text-center text-blue-700 font-medium">Write Comment</a>
        </div>
        <Comments :props="{
            postId: props.post.id,
            comments: props.post.post_comments,
            user: props.user,
            csrf: props.csrf
            }" :class="{'border-t border-gray-200' : props.post.post_comments.length > 0}"/>
    </div>

</div>
</template>

<script>

import VueMomentsAgo from 'vue-moments-ago'
import Comments from './Comments.vue'
export default {
    props:['props'],
    data(){
        return {
            isLikedByMe: false,
            isCommentsOpen: false
        }
    },
    methods: {
        pluralize(word, amount){
            return amount > 1 || amount == 0 ? `${word}s` : word
        },
        showComments(){
            this.isCommentsOpen = !this.isCommentsOpen
        },
        deletePost(){
            axios.delete('/api/posts/' + this.props.post.id)
            .then(resp => resp.status == 200 ? this.$refs.post.remove() : null)
            .catch(err => console.log(err))
        },
        like(){
            const params = {
                'post_id': this.props.post.id,
                '_token': this.props.csrf
            }
            axios.post('/api/posts/like', params)
            .then(resp => {
                this.isLikedByMe = true
                this.props.post.likes.push(resp.data[0])
            })
            .catch(err => console.log(err))
        },
        unlike(){
            const params = {
                'post_id': this.props.post.id,
                '_token': this.props.csrf
            }
            axios.delete(`/api/posts/${this.props.post.id}/like`, params)
            .then(resp => {
                this.props.post.likes = this.props.post.likes.filter(like => console.log(like))
                this.isLikedByMe = resp.data.isLikedByMe
            })
            .catch(err => console.log(err))
        }
    },
    mounted(){
        this.props.post.likes.forEach(like => {
            if(like.user_id == this.props.user.id){
                this.isLikedByMe = true
                return
            }
        })
        
    },
    computed:{
        deleteLike(id){
            console.log(id)
            // return this.props.post.likes.filter(like => like.id == id)
        }
    },
    components: {VueMomentsAgo, Comments}
}
</script>

<style>

</style>