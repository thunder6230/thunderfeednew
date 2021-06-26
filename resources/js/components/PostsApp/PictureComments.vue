<template>
<div class="py-2 border-t border-blue-200">
    <ul class="flex flex-col overflow-auto overflow-auto" style="height: auto; max-height: 100%; overflow: auto;">
        <Comment v-for="comment in props.comments" :key="comment.id" :props="{
            comment: comment,
            user: props.user,
            csrf: props.csrf,
            auth: props.auth,
        }" 
            @removeComment="removeComment"/>
    </ul>
    <!-- <p 
        v-on:click="showHideComments"
        v-if="props.comments.length > 2 && allCommentsHidden == true" 
        class="font-medium pb-2 cursor-pointer">Show All Comments</p> -->
    <AddPictureComment :props="{
        pictureId: props.pictureId,
        user: props.user,
        csrf: props.csrf,
        isWriteComment: props.isWriteComment
    }" @newComment="addComment" v-if="props.auth == true"/>
</div>
</template>

<script>
import Comment from './Comment.vue'
import AddPictureComment from './AddPictureComment.vue'
export default {
    props:['props'],
    data(){
        return{
            allCommentsHidden: true,

        }
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
        },
    },
    components: { Comment, AddPictureComment }
}
</script>

<style>

</style>