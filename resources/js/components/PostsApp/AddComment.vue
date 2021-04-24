<template>
    <form ref="form" enctype="multipart/form-data" @submit.prevent="submit" class="relative">
        <input type="text" name="body" id="body" class="w-full border border-blue-200 rounded-xl px-4 py-2" placeholder="What's in you mind?" ref="body">

        <label for="image"
        class="cursor-pointer bg-transparent px-2 py-0 text-blue-700 text-2xl absolute right-12 top-1.5 border-r border-gray-200">
            <i class="fas fa-image"></i>
        </label>
        <input type="file" name="file" id="image" class="hidden" @change="handleFileInput">
        
        <button type="submit"
        class="bg-transparent px-2 py-0 text-blue-700 text-xl absolute right-2 top-2"><i class="fa fa-paper-plane"></i></button>
    </form>
</template>

<script>
export default {
    props:['props'],
    methods:{
        submit(){
            const params = {
                '_token': this.props.csrf,
                'body': this.$refs.body.value,
                'file': this.$refs.image.value ?? "",
            }
            axios.post(`/api/posts/${this.props.postId}/comment`, params)
            .then(resp => console.log(resp))
            .catch(error => error.response)
        }
    }
}
</script>

<style>

</style>