<template>
  <div class="bg-gray-50 py-2 rounded-md  text-blue-700 text-center" style="width: 600px;" @click.stop>
      <h1 class="text-3xl font-bold my-2">Registration</h1>
      <form @submit.prevent="submitRegister" class="flex-col items-center justify-center w-full px-4 py-2 text-blue-700">
          <input class="mb-2 w-full px-2 py-1 border border-blue-700 rounded-md" type="text" v-model="name" placeholder="Your Name" >
          <p class="text-red-500 text-center" v-for="(error,index) in errors.name" :key="index">{{error}}</p>
          <input class="mb-2 w-full px-2 py-1 border border-blue-700 rounded-md" type="text" v-model="username" placeholder="Your Username">
          <p class="text-red-500 text-center" v-for="(error,index) in errors.username" :key="index">{{error}}</p>
          <input class="mb-2 w-full px-2 py-1 border border-blue-700 rounded-md" type="email" v-model="email" placeholder="Your Email Address">
          <p class="text-red-500 text-center" v-for="(error,index) in errors.email" :key="index">{{error}}</p>
          <p class="text-red-500 text-center" ref="usedEmailError"></p>
          <input class="mb-2 w-full px-2 py-1 border border-blue-700 rounded-md" type="password" v-model="password" placeholder="Your Password">
          <p class="text-red-500 text-center" v-for="(error,index) in errors.password" :key="index">{{error}}</p>
          <input class="mb-2 w-full px-2 py-1 border border-blue-700 rounded-md" type="password" v-model="password_confirmation" placeholder="Password Again">
          <p class="text-red-500 text-center"></p>
          <div class="mb-4 flex justify-center items-center">
                <div class="mr-5 flex justify-center items-center">
                    <label for="male" class=""><i class="fas fa-mars text-4xl text-blue-600"></i>
                        <input type="radio" name="gender" value="male" v-model="gender" class="">
                    </label>
                </div>
                <div>

                    <label for="female" class=""><i class="fas fa-venus text-4xl text-pink-500"></i>
                        <input type="radio" name="gender" value="female" v-model="gender" class="">
                    </label>
                </div>
            </div>
            <p class="text-red-500 text-center" v-for="(error,index) in errors.gender" :key="index">{{error}}</p>
            <button type="submit" class="bg-blue-700 w-full py-2 text-white rounded-md">Register</button>
          
      </form>
      <small class="cursor-pointer" @click="$emit('changeModal')">Already have an Account? Click to Login</small>
  </div>
</template>

<script>
export default {
    props: ['props'],
    data(){
        return {
            name: "",
            username: "",
            email: "",
            password: "",
            password_confirmation: "",
            gender: "",
            errors: {}
        }
    },
    methods: {
        submitRegister(){
            this.errors = {}
            const params = {
                name: this.name,
                username: this.username,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                gender: this.gender,
                path: window.location.pathname
            }
            axios.post('/register', params)
            .then(resp => resp.data.success ? document.location.href = resp.data.path : this.$refs.usedEmailError.textContent = resp.data.message)
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