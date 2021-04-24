<template>
    <div class="contact_list w-4/12 min-h-full overflow-auto" ref="list"
        @mouseenter="showsScrollbar"
        @mouseleave="hideScrollbar">
        <ul class="divide-y divide-gray-100">
            <input type="text" @keydown="filterContacts" class="">
            <li
                v-for="(contact) in sortByNewMessages" :key="contact.id" 
                class="flex px-4 py-2 w-full  items-center hover:bg-gray-100 cursor-pointer relative"
                v-bind:data-id="contact.id"
                @click="selectContact(contact)"
                :class="{ 'bg-gray-100 border-x border-gray-500': contact == selected}"
                > 
                    <img v-bind:src="'/storage/' + contact.profile_picture" alt="" class="rounded-full w-8 mr-5 ">
                    <p class="">{{ contact.name }}</p>
                <div v-if="contact.unread > 0" class="w-5 rounded-lg bg-red-500 absolute left-10 top-0">
                    <p class="text-white font-medium text-center text-sm">{{contact.unread}}</p>
                </div>
            </li>
        </ul>
    </div>
</template>
<style>
    ul{
        width: 98%
    }
</style>

<script>
    export default {
        props:['contacts', 'messages'],
        data(){
            return{
                selected : 0
            }
        },
        mounted() {

        },
        methods:{
            selectContact(contact){
                this.selected = contact
                this.$emit('selected', contact)
            },
            showsScrollbar(){
                this.$refs.list.style.overflow = "auto"
            },
            hideScrollbar(){
                this.$refs.list.style.overflow = "hidden"
            },
            filterContacts(){

            }
        },
        computed: {
            sortByNewMessages: function () {
                return _.orderBy(this.contacts, [(contact => {
                    if(contact.id == this.selected.id){
                        return Infinity;
                    }
                    return contact.unread
                })]).reverse()
            }
        }
    }
</script>
