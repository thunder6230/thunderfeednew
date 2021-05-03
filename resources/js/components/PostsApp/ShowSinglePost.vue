<template>
    <div class="container lg:w-8/12 m-auto">
        <Post :props="{
            user: props.user,
            post: props.post[0],
        }"/>
    </div>
</template>

<script>
import Post from './Post'
export default {
    props: ['props'],
    components: { Post }
}
</script>

<style>

</style>