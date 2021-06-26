<template>
  <div>
      <form @submit.prevent="submitPassword" class="flex flex-col items-center justify-center px-4 py-2 bg-white rounded-md">
          <div>
              <label for="">Current Password</label>
              <input type="password" v-model="oldPassword">
          </div>
          <div>
              <label for="">New Password</label>
              <input type="password" v-model="password">
          </div>
          <div>
              <label for="">Confirm Password</label>
              <input type="password" v-model="password_confirmation">
          </div>
          <p class="text-red-500">{{passwordMessage}}</p>
          <button>Change Password</button>
      </form>
  </div>
</template>

<script>
export default {
    props:['user', 'csrf'],
    data(){
        return{
            oldPassword:"",
            password: "",
            password_confirmation: "",
            passwordMessage: ""
        }
    },
    methods: {
        submitPassword(){
            this.passwordMessage = ""
            const params = {
                '_token': this.csrf,
                'oldPassword': this.oldPassword,
                'password': this.password,
                'password_confirmation': this.password_confirmation,
            }
            axios.post('/api/updatePassword', params).then(resp => {
                if(resp.data.success){
                    this.oldPassword = ""
                    this.password = ""
                    this.password_confirmation = ""
                    return alert(resp.data.message)

                }
                this.passwordMessage = resp.data.message
            }).catch(error => this.passwordMessage = error.response.data.errors.password[0])
        }
    }
}
</script>

<style>

</style>