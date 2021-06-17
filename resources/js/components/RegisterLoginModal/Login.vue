<template>
  <div class="bg-gray-50 py-2 rounded-md" style="width: 600px;" @click.stop>
      <h1 class="text-center text-blue-700 text-3xl font-bold my-2">Login</h1>
      <form @submit.prevent="submitLogin" class="flex-col items-center justify-center w-full px-4 py-2 text-blue-700">
        <input class="mb-2 w-full px-2 py-1 border border-blue-700 rounded-md" type="email" v-model="email" placeholder="Your Email Address">
        <input class="mb-2 w-full px-2 py-1 border border-blue-700 rounded-md" type="password" v-model="password" placeholder="Your Password">
        <p class="text-red-500 text-center" ref="loginError">{{errors.login}}</p>
        <button type="submit" class="bg-blue-700 w-full py-2 text-white rounded-md">Login</button>
          
      </form>
  </div>
</template>

<script>
export default {
    props: ['props'],
    data(){
        return {
            email: "",
            password: "",
            errors: {}
        }
    },
    methods: {
        submitLogin(){
            this.errors = {}
            const params = {
                email: this.email,
                password: this.password,
            }
            axios.post('/login', params)
            .then(resp => resp.data.success ? document.location.href = resp.data.path : this.$refs.loginError.textContent = resp.data.message)
            .catch(err => {
                this.errors = err.response.data.errors
            }
            )
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