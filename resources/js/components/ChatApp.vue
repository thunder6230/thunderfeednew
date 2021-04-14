
<template>
    <div class="container bg-gray-200 h-5/6 relative shadow-lg">
        <h1 class="text-2xl font-bold text-right">ThunderFeed Messenger</h1>
        <div class="flex h-full absolute w-full top-0 pt-12 overflow-hidden">
            <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
            <ContactList :contacts="contacts" @selected="startConversationWith" />
        </div>
    </div>
</template>

<script>
import Conversation from './Conversation'
import ContactList from './ContactList'
    export default {
        props: ['user'],
        
        data(){
            return{
                selectedContact: null,
                messages: [],
                contacts: [],
            }
        },
        mounted() {
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e => {
                    this.handleIncoming(e.message)
                }))
            axios.get('/api/users')
            .then(resp => this.contacts = resp.data)

        },
        methods:{
            startConversationWith(contact){
                axios.get('/api/conversation/' + contact.id)
                .then(resp => {
                    this.messages = resp.data
                    this.selectedContact = contact
                })
            },
            saveNewMessage(text){
                this.messages.push(text)
            },
            handleIncoming(message) {
                console.log(message)
            }
        },
        components: { Conversation , ContactList }
    }
</script>
