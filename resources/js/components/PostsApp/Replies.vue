<template>

<div class="mt-5 ml-10">
    <p  v-on:click="showHideComments"
        v-if="props.replies.length > 2 && allCommentsHidden == true" 
        class="font-medium pb-1 cursor-pointer">
        Show All Replies
    </p>
    
    <Reply v-for="(reply, index) in props.replies" :key="reply.id" :props="{
        reply: reply,
        user: props.user,
        csrf: props.csrf,
        auth: props.auth,
    }" :class="{'hidden' : allCommentsHidden && index < props.replies.length - 2 }"
        @removeComment="removeComment" @isWritingActive="isWritingActive" />
    <AddReply :props="{
        comment_id: props.comment_id,
        user: props.user,
        csrf: props.csrf,
        isWritingReply: isWritingReply
    }" @newReply="addReply" v-if="isWritingReply" />
</div>
</template>

<script>
import Reply from './Reply'
import AddReply from './AddReply.vue'
export default {
    props:['props'],
    data(){
        return{
            allCommentsHidden: true,
            isWritingReply: false
        }
    },
    mounted(){
    },
    methods:{
        showHideComments(){
            this.allCommentsHidden = !this.allCommentsHidden
        },
        addReply(reply){
            this.props.replies.push(reply)
            this.isWritingReply = false
        },
        removeComment(id){
            this.$emit('removeComment', id)
        },
        isWritingActive(){
            this.isWritingReply = true

        }
    },
    components: { Reply, AddReply }
}
</script>

<style>

</style>