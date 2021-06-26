
<template>
    <div class="container bg-white h-full w-full relative shadow-lg rounded-lg">
    <!-- <div class="container bg-gray-200 h-4/6 relative shadow-lg rounded-lg" style="minHeight: 600px"> -->
        <div class="px-4 px-2 relative w-full border-b-2 border-blue-700 h-12">
            <h1 class="absolute left-4 top-2 text-xl">{{selectedContact ? `Conversation with ${selectedContact.name}` : "Select a Contact!"}}</h1>
            <h1 class="text-2xl font-bold text-right absolute right-4 top-2">ThunderFeed Messenger</h1>
        </div>
        <div class="flex h-full absolute w-full top-0 pt-12 overflow-hidden">
            <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage" />
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
                    console.log(e.message)
                    this.handleIncoming(e.message)
                }))
            axios.get('/api/getfriends')
            .then(resp => {
                this.contacts = resp.data
            })
        },
        methods:{
            startConversationWith(contact){
                contact.unread = 0
                axios.get('/api/conversation/' + contact.id)
                .then(resp => {
                    this.messages = resp.data
                    this.selectedContact = contact
                })
            },
            saveNewMessage(message){
                console.log(message)
                this.messages.push(message)
            },
            handleIncoming(message) {
                if(this.selectedContact && message.user_id == this.selectedContact.id){
                    axios.put('/api/messages/' + message.id)
                    .then(resp => this.saveNewMessage(resp.data))
                    .catch(error => console.log(error))
                    return
                }
                this.setMessageUnread(message)
                
            },
            setMessageUnread(message){
                let contacts = Object.keys(this.contacts)
                contacts.forEach((key,index) => {
                    let contact = this.contacts[key]
                    if(contact.id == message.user_id){
                        this.contacts[index].unread++
                    }
                })
            }
        },
        components: { Conversation , ContactList }
    }
</script>
<style >
   
</style>