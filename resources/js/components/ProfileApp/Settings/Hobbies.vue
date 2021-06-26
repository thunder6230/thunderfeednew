<template>
  <div>
    <div>
        <h1>My Hobbies</h1>
        <div class="flex flex-wrap items-center justify evenly w-full">
        <Hobby v-for="hobby in userHobbies" :key="hobby.id" :hobby="hobby"/>

        </div>
    </div>
    <div>
        <h1>Add new Hobbies</h1>
        <p ref="hobbyError" class="text-red-500 font-medium"></p>
        <input type="text" v-model="filter">
        <div style="max-height: 200px; overflow: auto;">
            <ul>
                <li v-for="hobby in filteredHobbies" :key="hobby.id" @click="selectHobby(hobby)">{{hobby.name}}</li>
            </ul>
        </div>
        <button @click="addHobby">Add to Profile</button>
    </div>

  </div>
</template>

<script>
import Hobby from './Hobby.vue'
export default {
    data(){
        return{
            hobbies: [],
            userHobbies: [],
            hobby: "",
            filter: ""
        }
    },
    mounted(){
        axios.get('/api/getUserHobbies').then(resp => this.userHobbies = resp.data).catch(error => console.log(error.response))

        axios.get('/api/getHobbies').then(resp => this.hobbies = resp.data).catch(error => console.log(error.response))
    },
    methods: {
        addHobby(){
            const params= {
                csrf: this.csrf,
                hobby_id: this.hobby

            }
            axios.post('/api/addHobby', params).then(resp => {
                if(!resp.data.success){
                    this.$refs.hobbyError.textContent = resp.data.message
                }
                this.userHobbies.push(resp.data.hobby)

            })
            
            .catch(error => console.log(error.response))
        },
        selectHobby(hobby){
            this.hobby = hobby.id
        }
    },
    computed:{
        filteredHobbies(){
            let filteredhobbies = this.hobbies.filter(hobby => {
                return hobby.name.toLowerCase().includes(this.filter.toLowerCase())
            })
            return filteredhobbies
        }
    },
    components: {Hobby}
}
</script>

<style>

</style>