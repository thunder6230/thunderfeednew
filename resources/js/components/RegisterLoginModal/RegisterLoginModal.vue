<template>
   <div class="fixed z-index-50 w-full h-screen bg-black bg-opacity-80 flex items-center justify-center top-0 left-0" @click="closeModal">
       <Login  v-if="props.isLoginActive" @success="loginSuccessfull" :props="{csrf: csrf}" @click.stop />
       <Register  v-if="props.isRegisterActive" @success="loginSuccessfull" :props="{csrf: csrf}" @click.stop/>
       <SuccessLogin v-if="isLoginSuccess" :props="{
           name: this.name
       }"/>
   </div>
</template>

<script>
import Login from '../RegisterLoginModal/Login.vue'
import Register from '../RegisterLoginModal/Register.vue'
export default {
    props:['props'],
    data() {
        return {
            isLoginActive: false,
            isRegisterActive: false,
            isLoginSuccess: false,
            isModalActive: false,
            name: "",
            csrf: document.head.querySelector('meta[name="csrf-token"]').content
    }},
    mounted(){
            this.isLoginActive = this.props.isLoginActive
            this.isRegisterActive = this.props.isRegisterActive
            this.isModalActive = this.props.isModalActive
            document.body.style.overflow = "hidden"
    },
    destroyed(){
                    document.body.style.overflow = "auto"

    },
    methods: {
        loginSuccessfull(loginData){
            this.name = loginData.name
        },
        openModal(type){
            
            this.resetModal()
            this.isModalActive = true
            switch(type) {
                case type == 'register':
                    this.isRegisterActive = true
                    return
                case type == 'login':
                    this.isLoginActive = true
                    return
                case type == 'loginSuccess':
                    this.isLoginSuccess = true
                    return
            }
        },
        resetModal(){
            this.isRegisterActive = false
            this.isLoginActive = false
            this.isLoginSuccess = false
            this.isModalActive = false

        },
        closeModal(){
            this.$emit("closeModal", {'isModalActive': false})
        }
    },
    components: {Login, Register }
}
</script>

<style>

</style>