<template>
  <nav class="flex justify-between w-full">
        <ul class="flex px-2 items-center">
            <li><a href="/" class="mr-3">Home</a></li>
            <li><a href="/posts" class="mr-3">Posts</a></li>
            <li><a href="/contact" class="mr-3">Contact</a></li>
            <li><a href="/about" class="mr-3">About</a></li>
            <li v-if="auth == true"><a href="/friends" class="mr-3">Friends</a></li>
            <li v-if="auth == true"><a href="/users" class="mr-3">Users</a></li>
            <li v-if="auth == true">
                <div class="relative mr-3">
                    <a :href="`/${user.username}/messages`">Messages</a>
                        <div class="notificationLabel" v-if="unreadMessages > 0">
                            <p class="labelContent">{{unreadMessages}}</p>
                        </div>
                </div>
            </li>
            <li>
            <div class="relative" v-if="auth == true && user.unread_notifications.length > 0">
                <button id="notificationBtn"  @click="clickHandle">Notifications</button>
                <Notifications :props="{
                    user:user,
                    unread_notifications: user.unread_notifications,
                    isDropdownOpen: isDropdownOpen}"/>
                <div class="notificationLabel">
                    <p class="labelContent">{{user.unread_notifications.length}}</p>
                </div>
            </div>
            <a :href="`/${user.username}/notifications`" v-if="auth==true && user.unread_notifications.length == 0">Notifications</a>
            </li>
        </ul>

        <ul class="flex px-2 items-center justify-end" >
            <li class="mr-3" v-if="auth == true">
                <a :href="`/profile/${user.username}`">
                    <div class="flex mr-3 justify-center items-center">
                            <img :src="`/storage/${user.picture.url}`" alt="" class="rounded-full w-7 mr-2">
                            {{user.name}}
                    </div>
                </a>
            </li>
            <li v-if="auth == true"><a href="/logout" class="mr-3">Logout</a></li>
            <li v-if="auth == false"><a href="/login" class="mr-3">Login</a></li>
            <li v-if="auth == false"><a href="/register" class="mr-3">Register</a></li>
        </ul>
    </nav>
</template>

<script>
import Notifications from './Notifications.vue'
export default {
    props:['user'],
    data(){
        return{
            auth: false,
            unreadMessages: 0,
            isDropdownOpen: false,

        }
    },
    beforeMount(){

        this.auth = this.user != 0 ? true : false
    },
    mounted(){
    
        if(this.auth){
            this.unreadMessages = this.user.unread_messages.length

            Echo.private(`messages.${this.user.id}`)
                    .listen('NewMessage', (e => {
                        this.handleIncoming(e.message)
                    }))
                axios.get('/api/users')
                .then(resp => {
                    this.contacts = resp.data
                })
        }

    },
    methods:{
        handleIncoming(){
            this.unreadMessages++
        },
        clickHandle(){
            this.isDropdownOpen = !this.isDropdownOpen
            console.log(this.isDropdownOpen)
        }
    },
    components: { Notifications }

}
</script>

<style>

</style>