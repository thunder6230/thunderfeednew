<template>
    <div class="max-h-full h-auto absolute bottom-12 top-4 w-full " ref="feed"  
        @click="showMessageTime"
        @mouseenter="showsScrollbar"
        @mouseleave="hideScrollbar">
        <ul v-if="contact" class="flex flex-col">
            <li v-for="message in messages" 
                :class="`m-2 ${message.user_id == contact.id ? 'text-left' : 'text-right'}`"
                :key="message.id">
                    <ul style="width: fit-content" :class="`rounded-lg inline-block px-4 py-1 font-medium ${message.user_id == contact.id 
                            ? 'bg-blue-700 text-white' 
                            : 'bg-gray-100 text-blue-700'}`">
                        <li>{{message.body}}</li>
                        <li v-if="message.created_at" class="font-xs leading-3 font-extralight hidden" id="messageTime"><vue-moments-ago prefix="sent" suffix="ago" v-bind:date="message.created_at" lang="en"></vue-moments-ago></li>
                    </ul>
            </li>
        </ul>
    </div>
</template>

<script>
import VueMomentsAgo from 'vue-moments-ago'
export default {
    props: ['contact','messages'],
    methods: {
        showMessageTime(e){
            if(e.target.tagName.toLowerCase() == "li"){
                e.target.parentElement.querySelector('#messageTime').classList.toggle('hidden')
            }
        },
        scrollToBottom() {
            setTimeout(() => {
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight
            }, 50);
        },
        showsScrollbar(){
            this.$refs.feed.style.overflow = "auto"
        },
        hideScrollbar(){
            this.$refs.feed.style.overflow = "hidden"
        }
    },
    watch: {
        contact(contact) {
            this.scrollToBottom()

        },
        messages(messages) {
            this.scrollToBottom()
        }
    },
    components: { VueMomentsAgo }
}
</script>

<style>
::-webkit-scrollbar {
    width: 0.5em;
    background: transparent;
    transition: all 0.3s ease-in-out;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    border-radius: 10px;
    box-shadow: inset 0 0 6px rgba(3, 0, 187, 0.823);
    background: #1d4fd8;
}
</style>