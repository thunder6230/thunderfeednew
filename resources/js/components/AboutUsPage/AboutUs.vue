<template>
  <div>
      <div class="w-full bg-blue-700 flex items-center justify-center" style="height: 600px">
        <div class="flex w-full h-full relative items-center justify-around">
            <div class="flex-col items-center justify-center text-white">
                <h1 class="font-medium text-yellow-500" style="font-size: 7em; text-stroke: 1px white;">Thunderfeed</h1>
                <p class="text-3xl ml-4 mb-2">What is waiting for you on Thunderfeed?</p>
                <p class="ml-4">Please meet the technologies under the hood and check our main services!</p>
            </div>
            <div>
                <img src="/storage/logos/lightning_logo.svg" alt="" class="h-80">
                
            </div>
        </div>
    </div>
    <div class="flex flex-col w-8/12 mx-auto  my-16 justify-between" id="app">
        <div class="flex justify-around my-16">

            <div class="w-3/12 flex-col items-center">
                <h2 class="font-bold text-lg text-center mb-2">Look For Your Friends!</h2>
                <p class="text-center">Look for your friends and relatives or invite them to grow our community!</p>
            </div>
            <div class="w-3/12 flex-col items-center mb-2">
                <h2 class="font-bold text-lg text-center mb-2">Real time Chat</h2>
                <p class="text-center">We built a real time chat app for you to talk smooth with each other </p>
            </div>
            <div class="w-3/12 flex-col items-center mb-2">
                <h2 class="font-bold text-lg text-center mb-2">Share Posts and Pictures</h2>
                <p class="text-center">You can share anything you want like Pictures, Ideas your favourites with just one Click!</p>
            </div>
        </div>
        <div class="w-full flex-col justify-center align-center">
            <h2 class="text-center font-medium text-5xl mt-8">Technologies I used</h2>
            <div class="flex w-12/12 m-auto justify-around my-16">
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/HTML5.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">HTML 5</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/php.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">PHP</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/laravel.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">Laravel</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/pusher.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">Pusher Websocket</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/phpmyadmin.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">PHP MyAdmin</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/mysql.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">MySql</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/vuejs.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">Vue.JS</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/tailwindcss.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">Tailwind CSS</p>
                </div>
            </div>
        </div>
    </div>
    <div class="w-screen h-72 bg-blue-700 flex flex-col items-center justify-center ">
        <h1 style="font-size: 3em" class="mb-4 text-white text-medium">Are you ready to begin?</h1>
        <button @click="openModal('register')" class="px-4 py-2 text-xl text-medium bg-white rounded-xl" v-if="!auth">Create an Account</button>
        <a href="/posts" class="px-4 py-2 text-xl text-medium bg-white rounded-xl" v-else>Go To Posts</a>
    </div>
    <register-login-modal v-if="isModalActive" :props="{
            isRegisterActive: isRegisterActive, 
            isLoginActive:isLoginActive,
            isModalActive:isModalActive,
            isPasswordActive: isPasswordActive
            }" @closeModal="resetModal" @changeModal="changeModal"></register-login-modal>
  </div>
</template>

<script>
import RegisterLoginModal from '../RegisterLoginModal/RegisterLoginModal.vue'
export default {
    props: ['user'],
    data(){
        return {
            auth: false,
            isModalActive: false,
            isRegisterActive: false,
            isLoginActive: false,
            isPasswordActive: false
        }
    },
    mounted(){
        this.auth = this.user ? true : false
    },
    methods: {
        openModal(type){

            this.resetModal()
            this.isModalActive = true
            if(type == 'register'){
                return this.isRegisterActive = true
            } 
            if(type == 'login'){
                return this.isLoginActive = true
            }
            if(type == 'password'){
                return this.isPasswordActive = true
            }
        },
        resetModal(){
        this.isRegisterActive = false
        this.isLoginActive = false
        this.isPasswordActive = false
        this.isModalActive = false
        },
        changeModal(event){
            this.resetModal()
            setTimeout(() => this.openModal(event), 50)
        }
    },
    components: { RegisterLoginModal },

}
</script>

<style>

</style>