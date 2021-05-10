<template>
  <button :class="`flex-1 border-blue-700 ${props.activePage == props.page ? ' rounded-t-md text-blue-700 font-medium  text-lg border border-b-0 py-1 bg-gray-50' : 'py-0 border-0 border-b text-md opacity-50'}`" 
            @click="onClickHandle" :data-page="`${props.page}`">{{buttonTitle}}</button>
</template>

<script>
export default {
    props: ['props'],
    methods:{
        onClickHandle(event){
            let data = event.target.getAttribute('data-page')
            this.$emit('newActivePage', data)
        }
    },
    computed:{
        buttonTitle: function (){
            return this.props.page.charAt(0).toUpperCase() + this.props.page.slice(1)
        }
    }
}
</script>

<style>
button:focus {
    outline: none;
}
</style>