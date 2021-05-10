<template>
    <div class="container lg:w-8/12 m-auto">
        <Post :props="{
            user: userData,
            post: postData,
            auth: auth,
            csrf: csrf
        }"/>
    </div>
</template>

<script>
import Post from './Post'
export default {
    props:['user', 'post'],
    data(){
        return {
            userData: {},
            postData: {},
            auth: false,
            csrf: document.head.querySelector('meta[name="csrf-token"]').content
        }
    },
    beforeMount(){
        
        this.userData = JSON.parse(this.user)
        this.postData = JSON.parse(this.post)
        this.auth = this.userData != 0 ? true : false
    },
    components: { Post }
}
</script>

<style>

</style>