<template>
    <form @submit.prevent="submit" enctype="multipart/form-data" class="pt-4 mb-4 relative">
        <input type="text" name="body" id="body" class="w-full border border-blue-200 rounded-xl p-4" placeholder="What's in you mind?" ref="body">

        <label for="image"
        class="cursor-pointer bg-transparent px-2 py-1 text-blue-700 text-2xl absolute right-12 top-6 border-r border-gray-200">
            <i class="fas fa-image"></i>
        </label>
        <input type="file" name="file" id="image" class="hidden" @change="handleFileInput">
        
        <button type="submit"
        class="bg-transparent px-2 py-1 text-blue-700 text-2xl absolute right-2 top-6"><i class="fa fa-paper-plane"></i></button>

        
    </form>
</template>

<script>
export default {
    props: ['props'],
    data(){
        return{
            errors: {},
            file: null
        }
    },
    methods:{
        handleFileInput(event){
            this.file = event.target.files[0]
        },
        submit(){
            //we have to set content type for the file
            const config = {
                'content-type': 'multipart/form-data'
            }
            /**
             * Creating a new formData Object for the request
             */ 
            const formData = new FormData()
            if (this.file){
                formData.append('file', this.file)
            }
            formData.append('user_to_id', this.props.profile.id)
            formData.append('_token', this.props.csrf)
            formData.append('body', this.$refs.body.value)

            /**
             * Send the post request and append the post to posts array
             * If the validation gets error the errors will be sent to validationErrors satitizing method 
             */
            axios.post('/api/posts', formData, config)
            .then(resp => {
                this.$emit('newPost', resp.data)
                this.$refs.body.value = ""
            })
            .catch(error => {
                if(error.response.status == 422){
                    this.errors = error.response.data.errors
                }
            })
        }
    },
    computed: {
        validationErrors(){
            let errors = Object.values(this.errors)
            errors = errors.flat()
            return errors
        }
    }
}
</script>

<style>

</style>