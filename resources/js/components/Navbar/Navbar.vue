<template>
  <nav class="flex justify-between w-full">
        <ul class="flex px-2 items-center">
            <li><a href="/" class="mr-3">Home</a></li>
            <li><a href="/posts" class="mr-3">Posts</a></li>
            <li><a href="/contact" class="mr-3">Contact</a></li>
            <li><a href="/about" class="mr-3">About</a></li>
            <li><a href="/users" class="mr-3">Users</a></li>
            <li v-if="auth"><a href="/friends" class="mr-3">Friends</a></li>
            <li v-if="auth">
                <div class="relative mr-3">
                    <a :href="`/${user.username}/messages`">Messages</a>
                        <div class="absolute -right-2 -top-2 bg-red-500 px-1 py-0.5 rounded-md leading-3 flex items-center justify-center" v-if="unreadMessages > 0">
                            <small>{{unreadMessages}}</small>
                        </div>
                </div>
            </li>
            <li>
            <div class="relative w-max" v-if="auth && user.unread_notifications.length > 0">
                <button @click="clickHandle">Notifications</button>
                <Notifications :props="{
                    user:user,
                    unread_notifications: user.unread_notifications,
                    isDropdownOpen: isDropdownOpen}"/>
                <div class="absolute -right-2 -top-2 bg-red-500 px-1 py-0.5 rounded-md leading-3 flex items-center justify-center">
                    <small>{{user.unread_notifications.length}}</small>
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
            <li v-if="auth == false"><a href="#" class="mr-3" @click="isModalActive = true, isLoginActive = true">Login</a></li>
            <li v-if="auth == false"><a href="#" class="mr-3" @click="isModalActive = true, isRegisterActive = true">Register</a></li>
        </ul>
        <register-login-modal v-if="isModalActive" :props="{
            isRegisterActive: isRegisterActive, 
            isLoginActive:isLoginActive,
            isModalActive:isModalActive
            }" @closeModal="closeModal"></register-login-modal>
    </nav>
</template>

<script>
import Notifications from './Notifications.vue'
export default {
    props:['user', 'ismessages'],
    data(){
        return{
            auth: false,
            isDropdownOpen: false,
            unreadMessages: 0,
            isModalActive: false,
            isRegisterActive: false,
            isLoginActive: false
        }
    },
    beforeMount(){
        this.auth = this.user != 0 ? true : false

    },
    mounted(){
        if(this.auth && !this.ismessages){
            this.unreadMessages = this.user.unread_messages.length
            Echo.private(`messages.${this.user.id}`)
                    .listen('NewMessage', (e => {
                        this.handleIncoming(e.message)
                    }))
                // axios.get('/api/users')
                // .then(resp => {
                //     this.contacts = resp.data
                // })
        }
    },
    methods:{
        handleIncoming(){
            this.unreadMessages++
        },
        clickHandle(){
            this.isDropdownOpen = !this.isDropdownOpen
            console.log(this.isDropdownOpen)
        },
        closeModal(event){
            this.isModalActive = event.isModalActive
        }
    },
    components: { Notifications }

}
</script>

<style>

</style>