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
        @removeComment="removeComment" @isWritingReply="$emit('isWritingReply')" @openLogin="$emit('openLogin')"/>
    <AddReply :props="{
        comment_id: props.comment_id,
        user: props.user,
        csrf: props.csrf,
        isWritingReply: isWritingReply
    }" @newReply="addReply" v-if="props.isWritingReply" ref="input"/>
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
            isReplyOpen: 0,
        }
    },
    mounted(){
        this.isWritingReply = this.props.isWritingReply
    },
    updated(){
        // if(this.isWritingReply != this.props.isWritingReply){
        //     this.isWritingReply = this.props.isWritingReply
        // }
        document.addEventListener('click', (e) => {
            const dataRole = e.target.getAttribute('data-role')
            if(dataRole == "newReply"){
                if (this.props.isWritingReply){
                    return this.isWritingReply = true
                }
            }
            this.$emit('closeReply')

            
        })
    },
    watch: {
        
    },
    methods:{
        showHideComments(){
            this.allCommentsHidden = !this.allCommentsHidden
        },
        addReply(reply){
            this.props.replies.push(reply)
            this.$emit('closeReply')
        },
        removeComment(id){
            this.$emit('removeComment', id)
        },
    },
    components: { Reply, AddReply }
}
</script>

<style>

</style>