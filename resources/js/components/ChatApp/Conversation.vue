<template>
    <div class="conversation w-10/12 bg-gray-100 relative">
        <h1 class="font-xl">{{contact ? `Conversation with ${contact.name}` : "Select a Contact"}}</h1>
        <MessagesFeed :contact="contact" :messages="messages" />
        <MessageComposer @send="sendMessage" />
    </div>
</template>

<script>
import MessageComposer from './MessageComposer.vue'
import MessagesFeed from './MessagesFeed.vue'

    export default {
        components: { MessagesFeed },
        props:['contact', 'messages'],
        data(){
            return{
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            sendMessage(text){
                if(!this.contact) {
                    return
                }
                const params = {
                    contact: this.contact.id,
                    text: text,
                }

                axios.post('/api/conversation', params)
                    .then(resp => this.$emit('new', resp.data))
                    .catch(console.log)
            }
        },
        components: {MessagesFeed, MessageComposer}
    }
</script>
