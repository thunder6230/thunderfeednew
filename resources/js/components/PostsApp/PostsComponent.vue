<template>
<div>
    <p v-if="props.posts.length == 0">Be your Post be the First!</p>
    <Post v-for="post in props.posts" :key="post.id" :props="{
        post: post,
        user: props.user,
        csrf: props.csrf
        }" @deletePost="deletePost"/>
</div>
  
</template>

<script>
import Post from './Post.vue'
import Comments from './Comments.vue'
export default {
    props: ['props'],
    methods:{
        deletePost(post){
            this.$emit('deletePost', post)
        }
    },
    components: {Post, Comments}
}
</script>

<style>

</style>