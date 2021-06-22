<template>
  <div class="bg-gray-50 py-2 rounded-md text-blue-700 text-center" style="width: 600px;" @click.stop>
      <h1 class="text-center text-blue-700 text-3xl font-bold my-2">Password Reset</h1>
      <form @submit.prevent="submitPWReset" class="flex-col items-center justify-center w-full px-4 py-2 text-blue-700">
        <input class="mb-2 w-full px-2 py-1 border border-blue-700 rounded-md" type="email" v-model="email" placeholder="Your Email Address">
        <p class="text-red-500 text-center" ref="loginError"></p>
        <button type="submit" class="bg-blue-700 w-full py-2 text-white rounded-md">Send Request</button>
      </form>
      <small class="cursor-pointer" @click="$emit('changeModal')">Back to Login</small>
  </div>
</template>

<script>
export default {
    props: ['props'],
    data(){
        return {
            email: "",
            errors: {}
        }
    },
    methods: {
        submitPWReset(){
            this.errors = {}
            const params = {
                email: this.email,
                csrf: this.props.csrf,
                path: window.location.pathname
            }
            console.log(params)
            axios.post('/pwreset', params)
            .then(resp => console.log(resp))
            .catch(err => this.errors = err.response.data.errors)
        },
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