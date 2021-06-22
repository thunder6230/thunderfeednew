<template>
  <div class="bg-gray-50 py-2 rounded-md text-blue-700 text-center" style="width: 600px;" @click.stop>
      <h1 class="text-center text-blue-700 text-3xl font-bold my-2">Login</h1>
      <p v-if="props.loginMessage">You have to login to continue!</p>
      <form @submit.prevent="submitLogin" class="flex-col items-center justify-center w-full px-4 py-2 text-blue-700">
        <input class="mb-2 w-full px-2 py-1 border border-blue-700 rounded-md" type="email" v-model="email" placeholder="Your Email Address">
        <input class="mb-2 w-full px-2 py-1 border border-blue-700 rounded-md" type="password" v-model="password" placeholder="Your Password">
        <p class="text-red-500 text-center" ref="loginError">{{errors.login}}</p>
        <div class="w-full flex justify-between mb-2">
        <label class="text-left"><input type="checkbox" v-model="remember" class="mr-2">Remember me</label>
        <p @click="$emit('changeModal', 'password')" class="cursor-pointer">Forgot Password?</p>
        </div>
        <button type="submit" class="bg-blue-700 w-full py-2 text-white rounded-md">Login</button>
          
      </form>
      <small class="cursor-pointer" @click="$emit('changeModal', 'register')">No accounts yet? Click to Register</small>
  </div>
</template>

<script>
export default {
    props: ['props'],
    data(){
        return {
            email: "",
            password: "",
            remember: false,
            errors: {}
        }
    },
    methods: {
        submitLogin(){
            this.errors = {}
            const params = {
                email: this.email,
                password: this.password,
                remember: this.remember,
                path: window.location.pathname
            }
            axios.post('/login', params)
            .then(resp => resp.data.success ? document.location.href = resp.data.path : this.$refs.loginError.textContent = resp.data.message)
            .catch(err => {
                this.errors = err.response.data.errors
            }
            )
        },
        forgotPassword(){
            
        }
    },
    computed: {
        validationErrors(){
            let errors = Object.values(this.errors)
            errors = errors.flat()
            return errors
        }
    }
}
</script>

<style>

</style>