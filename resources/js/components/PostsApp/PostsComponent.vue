<template>
<div>
    <h1 v-if="props.isLoading == false && props.posts.length == 0" class="text-center font-bold text-2xl text-blue-700 block m-auto py-4">Be your Post be the First!</h1>
    <Post v-for="post in props.posts" :key="post.id" :props="{
        post: post,
        user: props.user,
        csrf: props.csrf,
        auth: props.auth
        }" @openLogin="$emit('openLogin')"/>
</div>
  
</template>

<script>
import Post from './Post.vue'
import Comments from './Comments.vue'
export default {
    props: ['props'],
    components: {Post, Comments}
}
</script>

<style>

</style>