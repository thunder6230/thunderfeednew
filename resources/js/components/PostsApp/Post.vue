<template>
<div ref="post"
    @mouseenter="handleMouseEnter"
    @mouseleave="handleMouseLeave"
    class="rounded-xl mb-4 p-4 bg-white border border-blue-200 shadow-lg">
    <div class="relative flex">
            <a :href="`/profile/${props.post.user.username}`" class="w-10 mr-2">
                <img :src="`/storage/${props.post.user.picture.url}`"
                    :alt="`${props.post.user.username}`" class="rounded-full w-10">
            </a>
            <div class="flex flex-col justify-end">
                <div class="text-lg leading-3 pb-0.5
text-lg leading-3 pb-0.5">
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
            <button type="button" @click="confirmDelete"><i class="far fa-times-circle text-red-500"></i></button>
        </div>
    </div>
    <div class="px-4">
        <p class="px-1">{{props.post.body}}</p>
    </div>
    <img :src="`/storage/${props.post.picture.url}`" alt="" class="rounded" v-if="props.post.picture">
    <div class="px-4">
        <div class="flex justify-around py-2">
            <p>{{ props.post.likes.length }} {{pluralize('Like', props.post.likes.length)}}</p>
            <p>{{ props.post.post_comments.length}} {{pluralize('Comment', props.post.post_comments.length)}}</p>
        </div>
        <div v-if="props.user" class="flex items-center py-2 border-t border-blue-200 ">
                
            <button v-if="isLikedByMe == false" type="button" 
            class="flex-1 text-blue-700 font-medium" @click="like">

            <i class="fas fa-thumbs-up"></i> Like</button>
            <button v-else type="button" 
            class="flex-1 text-blue-700 font-medium text-lg" @click="unlike">
            <i class="fas fa-thumbs-up transform rotate-180 pb-1 text-lg"></i> Unlike</button>

            <a :href="`#comment_body${props.post.id}`" class="flex-1 text-center text-blue-700 font-medium text-lg"><i class="far fa-comment-dots"></i> Write Comment</a>
        </div>
        <Comments :props="{
            postId: props.post.id,
            comments: props.post.post_comments,
            user: props.user,
            csrf: props.csrf
        }" />
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
            isCommentsOpen: false,
            isMyPost: false,
            isMouseEnter: false
        }
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
            const params = {
                'post_id': this.props.post.id,
                '_token': this.props.csrf
            }
            axios.post('/api/posts/like', params)
            .then(resp => {
                this.isLikedByMe = true
                this.props.post.likes.push(resp.data)
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
                if (resp.status == 200){
                    this.props.post.likes = this.props.post.likes.filter(like => like.user_liked_id == this.props.user.id ? false : true)
                    this.isLikedByMe = false
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
        }
    },
    mounted(){
        
        if(this.props.user){
            this.props.post.likes.forEach(like => {
                if(like.user_liked_id == this.props.user.id){
                    this.isLikedByMe = true
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