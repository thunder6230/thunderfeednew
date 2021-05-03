<template>
<div class="py-2">
    <Comment v-for="(comment, index) in props.comments" :key="comment.id" :props="{
        comment: comment,
        user: props.user,
        csrf: props.csrf
    }" :class="{'hidden' : allCommentsHidden && index < props.comments.length - 2 }" />
    <p 
        v-on:click="showHideComments"
        v-if="props.comments.length > 2 && allCommentsHidden == true" 
        class="font-medium pb-2 cursor-pointer">Show All Comments</p>
    <AddComment :props="{
        postId: props.postId,
        user: props.user,
        csrf: props.csrf
    }" @newComment="addComment" />
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
        // console.log(this.props)
    },
    methods:{
        showHideComments(){
            this.allCommentsHidden = !this.allCommentsHidden
        },
        addComment(comment){
            this.props.comments.push(comment)
        },
    },
    components: { Comment, AddComment }
}
</script>

<style>

</style>