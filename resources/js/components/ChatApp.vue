
<template>
    <div class="container bg-gray-200 h-5/6 relative shadow-lg">
        <h1 class="text-2xl font-bold text-right">ThunderFeed Messenger</h1>
        <div class="flex h-full absolute w-full top-0 pt-12 overflow-hidden">
            <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
            <ContactList :contacts="contacts" @selected="startConversationWith" :unreadMessages="unreadMessages"/>
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
                unreadMessages:[]
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
                //if the new message is from the current selected contact
                if(this.selectedContact && message.user_id == this.selectedContact.id){
                    this.saveNewMessage(message)
                    
                    //update message to read
                    // axios.post('api/conversation/' . message.id).then(resp => {
                    //     if(resp.status == 200){
                    //         return
                    //     }
                    // }).catch(error => console.log(error))
                }
               
            }
        },
        components: { Conversation , ContactList }
    }
</script>
