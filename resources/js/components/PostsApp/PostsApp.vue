<template>
     <div class="container lg:w-8/12 m-auto pb-4">
        <AddPostComponent v-if="user" :csrf="csrf" @newPost="addPost" />
        <PostsComponent :props="{
            posts: posts,
            user: user,
            csrf: csrf
        }" @deletePost="deletePost"/>

     </div>
</template>
<script>
import AddPostComponent from './AddPost'
import PostsComponent from './PostsComponent'
export default {
    props: ['user'],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            posts: []
        }
    },
    mounted(){
        axios.get('api/getposts')
        .then(resp => this.posts = resp.data)
        .catch(err => console.log(err))
    },
    methods:{
        addPost(post){
            
            this.posts.unshift(post)
        },
        deletePost(post){
            this.posts.Object.key
            console.log(post.post_id)
        },
        
    },
    components: {AddPostComponent, PostsComponent}
}
</script>
