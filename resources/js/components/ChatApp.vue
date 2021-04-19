
<template>
    <div class="container bg-gray-200 h-5/6 relative shadow-lg">
        <h1 class="text-2xl font-bold text-right">ThunderFeed Messenger</h1>
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
                    this.handleIncoming(e.message)
                }))
            axios.get('/api/users')
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
