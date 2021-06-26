<template>
<form @submit.prevent="submit" class="flex pb-2 items-center">
        <div class="mr-2">
            <img :src="`/storage/${props.user.pictures[props.user.pictures.length - 1].url}`" class="rounded-full w-8 h-8 object-cover">
        </div>
    <div class="bg-blue-50 rounded-lg">
        <input type="text" v-model="reply"
        class="bg-blue-50 rounded-md px-2 py-1  text-sm focus:ring focus:ring-blue-700 focus:outline-none" ref="input">
    </div>    
</form>
</template>

<script>
export default {
    props: ['props'],
    data(){
        return {
            reply: "",
            file: null
        }
    },
    mounted() {
        setTimeout(() => {
            this.$refs.input.focus()
        }, 50); 
    },
    methods: {
        submit(){
            const formData = new FormData()
                if (this.file){
                    formData.append('file', this.file)
                }
                formData.append('_token', this.props.csrf)
                formData.append('body', this.reply)
    
                axios.post(`/api/comments/${this.props.comment_id}/reply`, formData)
                .then(resp => {
                    this.$emit("newReply", resp.data)
                    this.file = null
                    this.reply = ""
                })
                .catch(error => error.response)
        },
        newReply(){
            this.$emit('newReply', this.reply)
            this.reply = ""
        }
    }
}
</script>

<style>

</style>