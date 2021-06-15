<template>
    <form ref="form" enctype="multipart/form-data" @submit.prevent="submit" class="relative">
        <input type="text" name="body" :id="`body${props.postId}`" class="w-full border border-blue-200 rounded-xl px-4 py-2" placeholder="What's in you mind?" ref="body">

        <label :for="`file${props.postId}`"
        class="cursor-pointer bg-transparent px-2.5 py-0 text-blue-700 text-2xl absolute right-11 top-1.5 border-r border-blue-200">
            <i class="fas fa-image"></i>
        </label>
        <input type="file" name="file" :id="`file${props.postId}`" class="hidden" @change="handleFileInput">
        
        <button type="submit"
        class="bg-transparent px-2 py-0 text-blue-700 text-xl absolute right-2 top-2"><i class="fa fa-paper-plane"></i></button>
    </form>
</template>

<script>
export default {
    props:['props'],
    data(){
        return{
            file: null,
            isWritingComment: false
        }
    },
    mounted(){
       
    },
    beforeUpdate(){
        this.isWritingComment = this.props.isWriteComment
        this.isWritingComment ? this.$refs.body.focus() : null
    },
    methods:{
        submit(){
            const formData = new FormData()
            if (this.file){
                formData.append('file', this.file)
            }
            formData.append('_token', this.props.csrf)
            formData.append('body', this.$refs.body.value)

            axios.post(`/api/posts/${this.props.postId}/comment`, formData)
            .then(resp => {
                this.$emit("newComment", resp.data[0])
                this.file = null
                this.$refs.body.value = ""
            })
            .catch(error => error.response)
        },
        handleFileInput(event){
            console.log('file added')
            this.file = event.target.files[0]
        },


    }
}
</script>

<style>

</style>