<template>
  <div class="flex items-start relative pb-2 mb-2" ref="reply">
        <div class="mr-2 flex-none">
            <a :href="`/profile/${props.reply.username}`">
                <img :src="`/storage/${props.reply.user.pictures[props.reply.user.pictures.length - 1].url}`" alt="" class="rounded-full w-8 h-8 object-cover">
            </a>
        </div>
        <div class="bg-blue-50 px-2 pt-1 pb-2 rounded-lg">
            <div>
                <a :href="`/profile/${props.reply.username}`" class="text-sm font-medium">{{props.reply.user.name}}</a>
                <vue-moments-ago prefix="" suffix="ago" v-bind:date="props.reply.created_at" lang="en" class="ml-5"></vue-moments-ago>
            </div>
            <div>
                <p class="text-md leading-3" v-if="!isEditOn">{{reply_body}}</p>
                    <form @submit.prevent="submitEdit" v-if="isEditOn">
                        <input type="text" ref="replyInput" v-model="newBody" class="text-md leading-3 px-1">
                    </form>
                    <!-- <img v-if="props.comment.picture != undefined" :src="`/storage/${props.comment.picture.url}`" alt="" class="rounded w-auto mr-2 pt-2"> -->
                <img v-if="props.reply.picture != undefined" :src="`/storage/${props.comment.picture.url}`" alt="" class="rounded w-auto mr-2 pt-2">
            </div>
        </div>
        <div class="flex absolute -bottom-1.5 left-12 text-xs text-blue-700 font-medium" >
            <p class="mr-1 cursor-pointer" @click="like" v-if="!isLikedByMe">Like</p>
            <p class="mr-1 cursor-pointer" @click="unlike" v-else>Unlike</p>
            <p class="mr-1 cursor-pointer" @click="replyComment" data-role="newReply">Reply</p>
            <p v-if="isMyComment" class="mr-1 cursor-pointer" @click="editComment">Edit</p>
            <p v-if="isMyComment" class="cursor-pointer" @click="confirmDelete(props.comment.id)" >Delete</p>
        </div>
  </div>
</template>

<script>

import VueMomentsAgo from 'vue-moments-ago'
export default {
    props: ['props'],
    data(){
        return {
            isMyComment: false,
            isLikedByMe: false,
            myLikeId: null,
            reply_body: this.props.reply.body,
            newBody: "",
            isEditOn: false
        }
    },
    mounted(){
        if(this.props.user){
            this.props.reply.likes.forEach(like => {
                if(like.user_liked_id == this.props.user.id){
                    this.isLikedByMe = true
                    this.myLikeId = like.id
                    return
                }
            })
            this.isMyComment = this.props.user.id == this.props.reply.user_id ? true : false
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
                'comment_id': this.props.reply.id,
                '_token': this.props.csrf
            }
            axios.post('/api/comments/like', params)
            .then(resp => {
                if(resp.status == 200){
                    this.isLikedByMe = true
                    this.myLikeId = resp.data.id
                    this.props.reply.likes.push(resp.data)
                }
            })
            .catch(err => console.log(err))
        },
        unlike(){
            axios.delete(`/api/like/${this.myLikeId}/unlike`)
            .then(resp => {
                if (resp.status == 200){
                    this.props.reply.likes = this.props.reply.likes.filter(like => like.id != this.myLikeId)
                    this.isLikedByMe = false
                    this.myLikeId = null
                }
                return
            })
            .catch(err => console.log(err))
        },
        replyComment(){
            if(!this.props.auth){
                return this.$emit('openLogin')
            }
            this.$emit('isWritingReply', this.props.reply.id)
        },
        
        editComment(){
            this.isEditOn = !this.isEditOn
            setTimeout(() => {
                this.$refs.replyInput.focus()
            }, 50);
        },
        submitEdit(){
            const params = {
                '_token': this.props.csrf,
                'new_body': this.newBody,
                'comment_id': this.props.reply.id
            }
            axios.post(`/api/comments/update`, params)
            .then(resp => {
                if(!resp.data.success){
                    alert('Something went wrong!')
                }

                this.reply_body = this.newBody
                this.isEditOn = false
                this.newBody = ""
            })
            .catch(error => console.log(error.response))
        }
    },
    components: {VueMomentsAgo}
}
</script>

<style>

</style>