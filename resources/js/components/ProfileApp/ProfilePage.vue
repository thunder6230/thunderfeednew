<template>
<div>
    <div class="bg-blue-100 rounded-t-lg">
        <div class="flex  items-end p-4 relative mt-4">
            <img :src="'/storage/' + userProfile.picture.url" alt="" class="w-40 rounded-full border-4 border-white mr-5">
            <div>
                <h1 class="text-3xl font-bold">{{userProfile.name}}</h1>
                <h2 class="text-xl font-normal">@{{userProfile.username}}</h2>
            </div>
            <div class="absolute right-0 text-sm pr-2" v-if="userLoggedIn.id != userProfile.id">
                <p><i class="fas fa-user-plus"></i> Add Friend</p>
                <p><i class="fas fa-user-minus"></i> Remove Friend</p>
                <p><i class="fas fa-user-plus"></i> Accept Friend</p>
            </div>
        </div>
        <div class="flex w-full text-black">
            <Button :props="{
                activePage: activePage,
                page: pages[index],
            }" @newActivePage="setActivePage" v-for="(page,index) in pages" :key="index" />
        </div> 
    </div>
    <div class="container 2xl:w-10/12 m-auto mt-4">
    <ProfilePosts v-if="activePage == pages[0]" :props="{
        csrf: csrf,
        userProfile: userProfile,
        userLoggedIn: userLoggedIn,
        auth: auth
    }" />
    <ProfileDatas v-if="activePage == pages[1]" />
    </div>
    <ProfileImages v-if="activePage == pages[2]" :props="{
        auth: auth,
        csrf: csrf,
        userProfile: userProfile,
        userLoggedIn: userLoggedIn
    }" @openModal="openModal"/>
    <modal @closeModal="isModalOpen = false" v-if="isModalOpen" :props="modalProps"></modal>
</div>
 
</template>

<script>
import ProfilePosts from '../ProfileApp/ProfilePosts.vue'
import ProfileDatas from '../ProfileApp/ProfileDatas.vue'
import ProfileImages from '../ProfileApp/ProfileImages.vue'
import Button from '../ProfileApp/Button.vue'

export default {
    props: ['profile', 'user'],
    data(){
        return{
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            auth: false,
            userProfile: {},
            userLoggedIn: {},
            pages: ['posts', 'datas', 'pictures'],
            activePage: "",
            isModalOpen: false,
            modalProps: {}
            
        }
    },
    created(){
        this.userProfile = JSON.parse(this.profile)
        this.userLoggedIn = JSON.parse(this.user)
        this.auth = this.userLoggedIn != 0 ? true : false
    },
    mounted(){
        this.setActivePage(this.pages[0])
    },
    methods: {
        setActivePage(data){
            console.log(data)
            this.activePage = data
        },
        openModal(props){
            this.modalProps = props
            this.isModalOpen = true
        }
    },
    components: { ProfilePosts, ProfileDatas, ProfileImages, Button },

}
</script>

<style>

</style>