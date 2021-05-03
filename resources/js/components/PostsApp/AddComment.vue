<template>
    <form ref="form" enctype="multipart/form-data" @submit.prevent="submit" class="relative">
        <input type="text" name="body" :id="`body${props.postId}`" class="w-full border border-blue-200 rounded-xl px-4 py-2" placeholder="What's in you mind?" ref="body">

        <label for="image"
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
            file: null
        }
    },
    methods:{
        submit(){
            const params = {
                '_token': this.props.csrf,
                'body': this.$refs.body.value,
                'file': this.file ?? "",
            }
            axios.post(`/api/posts/${this.props.postId}/comment`, params)
            .then(resp => this.$emit("newComment", resp.data))
            .catch(error => error.response)
        },
        handleFileInput(event){
            console.log('image added')
        }
    }
}
</script>

<style>

</style>