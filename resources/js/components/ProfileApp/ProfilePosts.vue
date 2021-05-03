<template>
    <div>
        <AddPostToUser @newPost="addPost" :props="{
            userProfile: props.users.userProfile,
            csrf: props.csrf
        }" />
        <posts-component :props="{
            posts: posts,
            user: props.users.userLoggedIn,
            csrf: props.csrf,
            loading: isLoading
        }"></posts-component>
    </div>
</template>

<script>
    import AddPostToUser from '../ProfileApp/AddPostToUser.vue'
    export default {
        props: ['props'],
        data() {
            return {
                posts: [],
                isLoading: true,
                isMorePosts: false,
                page: 1,
            }
        },
        mounted() {
            this.getPosts()
        },
        methods: {
            addPost(post) {
                this.posts.unshift(post)
            },
            getPosts() {
                axios.get(`/api/getuserposts?user_id=${this.props.users.userProfile.id}&page=${this.page}`)
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
            loadMorePosts() {
                this.isLoading = true
                axios.get(`/api/getuserposts?user_id=${this.props.users.userProfile.id}&page=${this.page}`)
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
            areMorePosts() {
                axios.get(`/api/getuserposts?user_id=${this.props.users.userProfile.id}&page=${this.page}`)
                    .then(resp => {
                        if (resp.data.length == 0) {
                            this.isMorePosts = false
                            return
                        }
                        this.isMorePosts = true
                    })
                    .catch(err => console.log(err.response))
            },
        },
        components: {
            AddPostToUser
        }

    }

</script>

<style>

</style>
