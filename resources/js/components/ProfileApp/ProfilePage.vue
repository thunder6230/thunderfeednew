<template>
<div>
 <div>
    <div class="flex bg-blue-100 rounded-t-lg items-end p-4 relative">
        <!-- <img :src="'/storage/' + users.userProfile.picture.url" alt="" class="w-40 rounded-full border-4 border-white mr-5"> -->
        <div>
            <h1 class="text-3xl font-bold">{{users.userProfile.name}}</h1>
            <h2 class="text-xl font-normal">@{{users.userProfile.username}}</h2>
        </div>
        <div class="absolute right-0 text-sm pr-2" v-if="users.userLoggedIn.id != users.userProfile.id">
            <p><i class="fas fa-user-plus"></i> Add Friend</p>
            <p><i class="fas fa-user-minus"></i> Remove Friend</p>
            <p><i class="fas fa-user-plus"></i> Accept Friend</p>
        </div>
    </div>
    <div class="flex w-full text-white">
        <button class="flex-1 border-b border-blue-700 bg-blue-100 " 
            :class="{'bg-blue-700' : activePage == 'posts'}" 
            @click="onClickHandle" data-page="posts">Posts</button>
        <button class="flex-1 border-b border-blue-700  bg-blue-100" 
            :class="{'bg-blue-700' : activePage == 'datas'}" 
            @click="onClickHandle" data-page="datas">Profile Datas</button>
        <button class="flex-1 border-b border-blue-700  bg-blue-100" 
            :class="{'bg-blue-700' : activePage == 'images'}" 
            @click="onClickHandle" data-page="images">Images</button>
    </div>
</div>
<div class="container 2xl:w-10/12 m-auto">
 <ProfilePosts v-if="activePage == 'posts'" :props="{
    csrf: csrf,
    users: users,
 }" />
 <ProfileDatas v-if="activePage == 'datas'" />
 <ProfileImages v-if="activePage == 'images'" />
</div>

</div>
 
</template>

<script>
import ProfilePosts from '../ProfileApp/ProfilePosts.vue'
import ProfileDatas from '../ProfileApp/ProfileDatas.vue'
import ProfileImages from '../ProfileApp/ProfileImages.vue'

export default {
    props: ['users'],
    data(){
        return{
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            activePage: "posts",
            posts: []
        }
    },
    methods: {
        onClickHandle(event){
            let data = event.target.getAttribute('data-page')
            this.activePage = data
        }
    },
    components: { ProfilePosts, ProfileDatas, ProfileImages },

}
</script>

<style>

</style>