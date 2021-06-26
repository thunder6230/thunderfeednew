<template>
<div>
    <div class="bg-blue-100 rounded-t-lg">
        <div class="flex  items-end p-4 relative mt-4">
            <img :src="'/storage/' + profile.pictures[profile.pictures.length - 1].url" alt="" class="w-40 h-40 object-cover rounded-full border-4 border-white mr-5">
            <div>
                <h1 class="text-3xl font-bold">{{profile.name}}</h1>
                <h2 class="text-xl font-normal">@{{profile.username}}</h2>
            </div>
            <div class="absolute right-0 text-sm pr-2" v-if="user.id != profile.id && auth">
                <p v-if="!isFriend && !isPending && !isRequestSent"><i class="fas fa-user-plus" ></i> Add Friend</p>
                <p v-if="isRequestSent"><i class="fas fa-user-plus" ></i>Request Sent</p>
                <p v-if="isFriend || isRequestSent"><i class="fas fa-user-minus" ></i> Remove Friend</p>
                <p v-if="isPending"><i class="fas fa-user-plus"></i> Accept Friend</p>
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
    <profilePosts v-if="activePage == pages[0]" :props="{
        csrf: csrf,
        profile: profile,
        user: user,
        auth: auth
    }" />
    <ProfileDatas v-if="activePage == pages[1]" />
    </div>
    <ProfileImages v-if="activePage == pages[2]" :props="{
        auth: auth,
        csrf: csrf,
        profile: profile,
        user: user,
        pictureId: picture
    }" @openModal="openModal"/>
    <ProfileSettings v-if="activePage == pages[3]" :user="user" :csrf="csrf"/>
    <modal @closeModal="isModalOpen = false" v-if="isModalOpen" :props="modalProps"></modal>
</div>
 
</template>

<script>
import ProfilePosts from '../ProfileApp/ProfilePosts.vue'
import ProfileDatas from '../ProfileApp/ProfileDatas.vue'
import ProfileImages from '../ProfileApp/ProfileImages.vue'
import ProfileSettings from '../ProfileApp/ProfileSettings.vue'
import Button from '../ProfileApp/Button.vue'

export default {
    props: ['profile', 'user', 'picture'],
    data(){
        return{
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            auth: false,
            pages: ['posts', 'datas', 'pictures'],
            activePage: "",
            isModalOpen: false,
            modalProps: {},
            isFriend: false,
            isFriendOf: false,
            isPending:false,
            isRequestSent: false
        }
    },
    created(){
        
        this.auth = this.user != 0 ? true : false
        if(this.auth){
            if(this.user.id == this.profile.id){
                this.pages.push('settings')
            }
            
            this.checkIfFriend(this.user.friends)
            if(!this.isFriend){
                this.checkIfFriend(this.user.friend_of)
            }
        }
    },
    mounted(){
        const pageCount = this.picture > 0 ? 2 : 0
        this.setActivePage(this.pages[pageCount])
    },
    methods: {
        setActivePage(data){
            console.log(data)
            this.activePage = data
        },
        openModal(props){
            this.modalProps = props
            this.isModalOpen = true
        },
        checkIfFriend(friendship){
            friendship.forEach(friend => {
                // console.log(friend.id == this.props.unreadNotification.data.user.id)
                
                if(friend.id == this.profile.id){
                    if(friend.pivot.accepted_at != null){
                        console.log(friend)
                        return this.isFriend = true
                    }
                    if(friendship == this.user.friend_of){
                        return this.isPending = true
                    }

                    return this.isRequestSent = true
                    
                }
            })
        },
    },
    components: { ProfilePosts, ProfileDatas, ProfileImages, Button, ProfileSettings },

}
</script>

<style>

</style>