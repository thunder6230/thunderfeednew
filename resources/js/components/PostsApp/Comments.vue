<template>
<div class="py-2 border-t border-blue-200">
    <ul class="flex flex-col">
        <Comment v-for="(comment, index) in props.comments" :key="comment.id" :props="{
            comment: comment,
            user: props.user,
            csrf: props.csrf,
            auth: props.auth,
        }" :class="{'hidden' : allCommentsHidden && index < props.comments.length - 2 }"
            @removeComment="removeComment"/>
    </ul>
    <p 
        v-on:click="showHideComments"
        v-if="props.comments.length > 2 && allCommentsHidden == true" 
        class="font-medium pb-2 cursor-pointer">Show All Comments</p>
    <AddComment :props="{
        postId: props.postId,
        user: props.user,
        csrf: props.csrf,
        isWriteComment: props.isWriteComment
    }" @newComment="addComment" v-if="props.auth == true"/>
</div>
</template>

<script>
import Comment from './Comment.vue'
import AddComment from './AddComment.vue'
export default {
    props:['props'],
    data(){
        return{
            allCommentsHidden: true
        }
    },
    mounted(){
    },
    methods:{
        showHideComments(){
            this.allCommentsHidden = !this.allCommentsHidden
        },
        addComment(comment){
            this.props.comments.push(comment)
        },
        removeComment(id){
            this.$emit('removeComment', id)
        }
    },
    components: { Comment, AddComment }
}
</script>

<style>

</style>