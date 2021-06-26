<template>
    <div class="w-full flex flex-col justify-center items-center">
        <ul class="flex justify-around items-center w-full">
          <li v-for="(tab, index) in tabs" :key="index" @click="activeTab = index" class="px-4 text-md hover:border-b-2 hover:border-blue-100" :class="`${activeTab == index ? 'border-b-2 border-blue-700 font-medium' : ''} `">{{tab}}</li>
        </ul>
        <Profile :user="user" :csrf="csrf" v-if="activeTab == 0"/>
        <Password :user="user" :csrf="csrf" v-if="activeTab == 1"/>
        <ContactInfo :user="user" :csrf="csrf" v-if="activeTab == 2"/>
        <Education :user="user" :csrf="csrf" v-if="activeTab == 3"/>
        <Hobbies :user="user" :csrf="csrf" v-if="activeTab == 4"/>
        
        
    </div>
</template>

<script>
import Profile from './Settings/Profile'
import Password from './Settings/Password'
import ContactInfo from './Settings/ContactInfo'
import Education from './Settings/Education'
import Hobbies from './Settings/Hobbies'
export default {
    props: ['user', 'csrf'],
    data(){
        return {
            tabs: ['Profile', 'Password', 'Contact Info', 'Education', 'Hobbies'],
            activeTab: 0
        }
    },
    methods:{
        
    },
    components: {Profile, Password, ContactInfo, Education, Hobbies}
}
</script>

<style>

</style>