<template>
  <div class="flex">
      <form @submit.prevent="submitPicture" enctype="multipart/form-data" class="flex flex-col items-center justify-center  px-4 py-2 bg-white rounded-md">
          <div>
              <p>Change Profile Picture</p>
              <img :src="`/storage/${user.pictures[user.pictures.length - 1].url}`" alt="">
              <p class="text-red-500">{{pictureMessage}}</p>
              <input type="file" @change="handleFile">
          </div>
          <button type="submit">Change Picture</button>
      </form>
      <form @submit.prevent="submitData" class="flex flex-col items-center justify-center  px-4 py-2 bg-white rounded-md" autocomplete="off">
          <div>
            <label for="">Name</label>
            <input type="text" v-model="name" placeholder="Your Name">
          </div>
          <div>
            <label for="">Username</label>
            <input type="text" v-model="username" placeholder="Your Username">
          </div>
          <div>
            <label for="">Email</label>
            <input type="email" v-model="email" placeholder="Your Email">
          </div>
          <div v-if="relationships.length > 0">
              <label>Relationship type</label>
              <select  class="text-blue-700">
                <!-- <option value="">--choose--</option> -->
                <option ref="options" :value="type.id" v-for="(type,index) in relationships" :key="index" >{{type.name}}</option>
              </select>
          </div>
          <button type="submit">Change</button>
      </form>
  </div>
</template>

<script>
export default {
    props: ['user', 'csrf'],
    data() {
        return{
            relationships: [],
            name: "",
            username: "",
            email: "",
            relationship: "",
            file: null,
            pictureMessage: "",

        }
    },
    beforeMount(){
      axios.get('/api/relationships').then(resp => {
        this.relationships = resp.data
        this.relationships.unshift({id:0,name: "--choose--"})
        })
      .catch(error => error.response)
      this.name = this.user.name
      this.username = this.user.username
      this.email = this.user.email
      this.relationship = this.user.relationship[0].name

    },
    mounted(){
      setTimeout(() => {
        
        this.selectRelationship()
      }, 300);
    },
    methods:{
      submitData(){
        const params = {
          csrf: this.csrf,
          name: this.name,
          username: this.username,
          email: this.email,
          relationship: this.relationship,
          file: this.file
          }
          axios.post('/api/updateData', params).then(resp => console.log(resp.data))
          // axios.post('/api/updateProfilePicture', params).then(resp => console.log(resp.data))
      },
      submitPicture(){
        this.pictureMessage = ""
        if(this.file == null){
          return this.pictureMessage =  'Please add a file to proceed!'
        }
          const config = {
                'content-type': 'multipart/form-data'
            }
            /**
             * Creating a new formData Object for the request
             */ 
            const formData = new FormData()
            formData.append('_token', this.csrf)
            formData.append('file', this.file)
            axios.post('/api/updatePicture', formData, config).then(resp => {
              if(resp.data.success){
                
                  window.location.reload()
              }
            }
            )
            .catch(error => this.pictureMessage = error.response.data.errors.file[0])
      
      },
      handleFile(event){
        this.pictureMessage = ""
        this.file = event.target.files[0]
      },
      selectRelationship(){
        if(this.relationship == ""){
          return
        }
        this.$refs.options.forEach(option => {
          if(option.textContent == this.relationship){
            return option.setAttribute('selected', true)
          }
        })
      } 
    }
}
</script>

<style>

</style>