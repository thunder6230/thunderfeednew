<template>
    <div class="container lg:w-8/12 m-auto">
        <post :props="{
            user: userData,
            post: postData,
            auth: auth,
            csrf: csrf
        }"></post>
    </div>
</template>

<script>
export default {
    props:['user', 'post_id'],
    data(){
        return {
            userData: {},
            postData: {},
            postID: 0,
            auth: false,
            csrf: document.head.querySelector('meta[name="csrf-token"]').content
        }
    },
    beforeMount(){
        this.userData = JSON.parse(this.user)
        this.auth = this.userData != 0 ? true : false
        
    },
    mounted(){
        axios.get(`/api/getpost/${this.post_id}`)
        .then(resp => this.postData = resp.data)
        .catch(error => console.log(error.response))
    },
}
</script>

<style>

</style>