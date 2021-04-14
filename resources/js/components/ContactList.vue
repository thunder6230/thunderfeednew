<template>
    <div class="contact_list w-4/12 h-full">
        <ul class="divide-y divide-gray-100">
            <li
                v-for="(contact, index) in contacts" :key="contact.id" 
                class="flex px-4 py-2 w-full items-center hover:bg-gray-100 cursor-pointer"
                v-bind:data-id="contact.id"
                @click="selectContact(index, contact)"
                :class="{ 'bg-gray-100 border-x border-gray-500': index == selected}"
                id="contactBtn"
                >
                <img v-bind:src="'/storage/' + contact.profile_picture" alt="" class="rounded-full w-8 mr-5">
                <p class="">{{ contact.name }}</p>
            </li>
        </ul>
    </div>
</template>


<script>
    export default {
        props:['contacts', 'messages'],
        data(){
            return{
                selected : null
            }
        },
        mounted() {

        },
        methods:{
            selectContact(index, contact){
                this.selected = index
                this.$emit('selected', contact)
            }
        }
    }
</script>
