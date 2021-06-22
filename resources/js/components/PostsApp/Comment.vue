<template>
    <li :class="`relative pb-2 inline-block`" ref="comment">
        <div class="flex">
            <div class="mr-2 flex-none">
                <a :href="`/profile/${props.comment.user.username}`">
                    <img :src="`/storage/${props.comment.user.picture.url}`" alt="" class="rounded-full w-8">
                </a>
            </div>
            <div class="bg-blue-200 px-2 pt-1 pb-2 rounded-lg relative">
                <div>
                    <a :href="`/profile/${props.comment.user.username}`" class="text-sm font-medium">{{props.comment.user.name}}</a>
                    <vue-moments-ago prefix="" suffix="ago" v-bind:date="props.comment.created_at" lang="en" class="ml-5"></vue-moments-ago>
                </div>
                <div>
                    <p class="text-md leading-3" v-if="!isEditOn">{{comment_body}}</p>
                    <form @submit.prevent="submitEdit" v-if="isEditOn">
                        <input type="text" ref="commentInput" v-model="newBody" class="text-md leading-3 px-1">
                    </form>
                    <img v-if="props.comment.picture != undefined" :src="`/storage/${props.comment.picture.url}`" alt="" class="rounded w-auto mr-2 pt-2">
                </div>
                <div class="flex absolute -bottom-3.5 left-1 text-xs text-blue-700 font-medium">
                    <p class="mr-1 cursor-pointer" @click="like" v-if="!isLikedByMe">Like</p>
                    <p class="mr-1 cursor-pointer" @click="unlike" v-else>Unlike</p>
                    <p class="mr-1 cursor-pointer" @click="props.auth ? isWritingReply = true : $emit('openLogin')" data-role="newReply" :data-id="props.comment.id">Reply</p>
                    <p v-if="isMyComment" class="mr-1 cursor-pointer" @click="editComment">Edit</p>
                    <p v-if="isMyComment" class="cursor-pointer"
                    @click="confirmDelete(props.comment.id)">Delete</p>
                </div>
            </div>
        </div>
        <Replies :props="{
            isWritingReply: isWritingReply,
            replies: props.comment.replies,
            user: props.user,
            csrf: props.csrf,
            auth: props.auth,
            comment_id: props.comment.id,
        }" @openLogin="$emit('openLogin')" @closeReply="isWritingReply = false" @isWritingReply="isWritingReply = true"/>
        
        
    </li>
</template>

<script>
import VueMomentsAgo from 'vue-moments-ago'
import Replies from './Replies.vue'
export default {
    props: ['props'],
    data(){
        return {
            isMyComment: false,
            isLikedByMe: false,
            myLikeId: null,
            isWritingReply: false,
            comment_body: this.props.comment.body,
            newBody: "",
            isEditOn: false
        }
    },
    mounted(){
        if(this.props.user){
            this.props.comment.likes.forEach(like => {
                if(like.user_liked_id == this.props.user.id){
                    this.isLikedByMe = true
                    this.myLikeId = like.id
                    return
                }
            })
            this.isMyComment = this.props.user.id == this.props.comment.user_id ? true : false
        }
    },
    methods: {
        confirmDelete(){
            if(!confirm('Are you sure you want to delete?')){
                return
            }
            this.deleteComment()
        },
        deleteComment(){
            axios.delete(`/api/posts/comments/${this.props.comment.id}`)
            .then(resp => {
                if(resp.status == 200){
                    this.$refs.comment.remove()
                    this.$emit('removeComment', resp.data)
                }
            })
            .catch(error => console.log(error.response))
        },
        like(){
            if(!this.props.auth){
                return this.$emit('openLogin')
            }
            const params = {
                'comment_id': this.props.comment.id,
                '_token': this.props.csrf
            }
            axios.post('/api/comments/like', params)
            .then(resp => {
                if(resp.status == 200){
                    this.isLikedByMe = true
                    this.myLikeId = resp.data.id
                    this.props.comment.likes.push(resp.data)
                }
            })
            .catch(err => console.log(err))
        },
        unlike(){
            axios.delete(`/api/like/${this.myLikeId}/unlike`)
            .then(resp => {
                if (resp.status == 200){
                    this.props.comment.likes = this.props.comment.likes.filter(like => like.id != this.myLikeId)
                    this.isLikedByMe = false
                    this.myLikeId = null
                }
                return
            })
            .catch(err => console.log(err))
        },
        editComment(){
            this.isEditOn = !this.isEditOn
            setTimeout(() => {
                this.$refs.commentInput.focus()
            }, 50);
        },
        submitEdit(){
            const params = {
                '_token': this.props.csrf,
                'new_body': this.newBody,
                'comment_id': this.props.comment.id
            }
            axios.post(`/api/comments/update`, params)
            .then(resp => {
                if(resp.data.success){
                    alert('Something went wrong!')
                }

                this.comment_body = this.newBody
                this.isEditOn = false
                this.newBody = ""
            })
            .catch(error => console.log(error.response))
        }
    },
    components: {VueMomentsAgo, Replies}
}
</script>

<style>

</style>