<template>
  <div class="absolute bottom-10 w-full absolute ">
      <input type="text" v-model="message" @keydown.enter="send" class="w-full rounded px-4 py-2 font-xl absolute">
      <div class="absolute right-0 flex justify-center">
        <label for="image" class="cursor-pointer p-2 bg-blue-700"><i class="fas fa-image"></i></label>
        <input type="file" name="file" id="image" class="hidden" @change="handleFileUpload">
        <button type="button" @click="send" class="p-2 bg-blue-700 text-white">Send</button>
      </div>
  </div>
</template>

<script>
export default {
    data() {
      return{
        message: ''
      }
    },
    methods: {
      send(e){
        e.preventDefault()
        
        if (this.message == ''){
          return
        }
        this.$emit('send', this.message)
        this.message = ''
      },
      handleFileUpload(e){
        console.log(e)
      }
    }
}
</script>

<style>

</style>