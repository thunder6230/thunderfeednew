<template>
    <div class="conversation w-10/12 bg-bg-white relative h-full">
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
