<template>
  <div class="">
      <p :style="`background: ${color};`" class="px-2 py-1 rounded-md font-medium text-white">{{hobby.name}}</p>
  </div>
</template>

<script>

export default {
    props: ['hobby'],
    data(){
        return {
            color: ""
        }
    },
    mounted(){
        this.color = this.$randomColor()
    },
    components: {}
}
</script>

<style>

</style>