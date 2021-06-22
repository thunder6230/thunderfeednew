<template>
    <div class="container lg:w-8/12 m-auto">
        <post :props="{
            user: user,
            post: post,
            auth: auth,
            csrf: csrf
        }" v-if="post != null"></post>
    </div>
</template>

<script>
export default {
    props:['user', 'post_id'],
    data(){
        return {
            post: null,
            auth: false,
            csrf: document.head.querySelector('meta[name="csrf-token"]').content
        }
    },
    beforeMount(){
        this.auth = this.userData != 0 ? true : false
        
    },
    mounted(){
        console.log(this.post_id)
        axios.get(`/api/getpost/${this.post_id}`)
        .then(resp => this.post = resp.data)
        .catch(error => console.log(error.response))
    },
}
</script>

<style>

</style>