<template>
   <div class="fixed z-50 w-full h-screen bg-black bg-opacity-80 flex items-center justify-center top-0 left-0" @click="$emit('closeModal')">
       <Login  v-if="props.isLoginActive" :props="{csrf: csrf,loginMessage: props.loginMessage}" @click.stop @changeModal="$emit('changeModal', $event)"/>
       <Register  v-if="props.isRegisterActive" :props="{csrf: csrf}" @click.stop @changeModal="$emit('changeModal', 'login')"/>
       <ForgotPassword  v-if="props.isPasswordActive" :props="{csrf: csrf}" @changeModal="$emit('changeModal', 'login')" @click.stop/>
   </div>
</template>

<script>
import Login from '../RegisterLoginModal/Login.vue'
import Register from '../RegisterLoginModal/Register.vue'
import ForgotPassword from '../RegisterLoginModal/ForgotPassword.vue'
export default {
    props:['props'],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]').content
    }},
    mounted(){
        document.body.style.overflow = "hidden"
    },
    destroyed(){
        document.body.style.overflow = "auto"

    },
    methods: {
        
    },
    components: {Login, Register, ForgotPassword }
}
</script>

<style>

</style>