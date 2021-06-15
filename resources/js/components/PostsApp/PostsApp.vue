<template>
     <div class="container lg:w-8/12 m-auto pb-4">
        <AddPostComponent v-if="auth" :csrf="csrf" @newPost="addPost" />
        <posts-component :props="{
            posts: posts,
            user: user,
            csrf: csrf,
            auth: auth,
            loading: isLoading
        }"></posts-component>
        <h1 v-if="isLoading" class="text-center font-bold text-2xl text-blue-700 block m-auto py-4">Loading...</h1>
        <div v-if="posts.length > 0" class="w-full flex justify-center">
            <button
                v-if="isMorePosts == true && isLoading == false"
                @click="loadMorePosts"
                class="text-center font-bold text-2xl text-white py-2 px-4 my-2 bg-blue-700 rounded-xl">Load more Posts</button>
            <h1 
                v-if="isMorePosts == false && isLoading == false"
                class="text-center font-bold text-2xl text-blue-700 block m-auto py-4">There are no more Posts</h1>
        </div>
        <div v-if="posts.length == 0" class="w-full flex justify-center">
            
            <h1 
                v-if="isMorePosts == false && isLoading == false"
                class="text-center font-bold text-2xl text-blue-700 block m-auto py-4">There are no Posts yet</h1>
        </div>
     </div>
</template>
<script>
import AddPostComponent from './AddPost'
export default {
    props: ['user'],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            isLoading: true,
            isMorePosts: false,
            page: 1,
            auth:false,
            posts: []
        }
    },
    mounted(){
        //get the posts for page 1
        this.getPosts()
        this.auth = this.user != 0 ? true : false
    },
    methods:{
        addPost(post){
            this.posts.unshift(post)
        },
        getPosts(){
            axios.get('api/getposts?page=' + this.page)
                .then(resp => {
                    this.posts = resp.data
                    this.page = this.page + 1
                    this.isLoading = false

                    this.areMorePosts()
                })
                .catch(err => {
                    this.isLoading = false
                    console.log(err)
            })
        },
        loadMorePosts(){
            this.isLoading = true
            axios.get('api/getmoreposts?page=' + this.page)
            .then(resp => {
                let posts = [...this.posts]
                resp.data.forEach(post => posts.push(post))
                this.posts = posts

                this.page = this.page + 1
                this.isLoading = false
                this.areMorePosts()
            })
            .catch(err => console.log(err.response))
        },
        areMorePosts(){
            axios.get('api/getmoreposts?page=' + this.page)
            .then(resp => {
                if(resp.data.length == 0){
                    this.isMorePosts = false
                    return
                }
                this.isMorePosts = true
            })
            .catch(err => console.log(err.response))
        },
        
    },
    components: { AddPostComponent }
}
</script>
