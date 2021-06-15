<template>
<div :class="`bg-white border border-blue-200 rounded shadow-md absolute w-60 -left-20 ${props.isDropdownOpen ? '' : 'hidden' }`">
    <ul>
        <Notification v-for="(unreadNotification,index) in props.unread_notifications" :key="unreadNotification.id" :props="unreadNotification"  :class="{'hidden': index > 3}"/>
        <div class="py-1 px-2 bg-white text-center text-blue-700 hover:bg-blue-100">
            <a :href="`/${props.user.username}/notifications`" class="font-medium">All Notifications</a>
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