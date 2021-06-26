<template>
<div style="width: 300px" :class="`bg-white border border-blue-200 rounded shadow-md absolute -left-28 ${props.isDropdownOpen ? '' : 'hidden' }`">
    <ul class="w-full h-auto" style="max-height: 300px;overflow:auto;">
        <Notification v-for="(unreadNotification,index) in props.unread_notifications" :key="unreadNotification.id" 
        :props="{
            unreadNotification: unreadNotification,
            user: props.user}"
        />
        <div class="py-1 px-2 bg-white text-center text-blue-700 hover:bg-blue-100">
            <a href="/notifications" class="font-medium">All Notifications</a>
        </div>
    </ul>
</div>

</template>

<script>
import Notification from './Notification.vue'
export default {
    props: ['props'],
    data(){
        return{
        }
    },
    components: { Notification }
}
</script>

<style>

</style>