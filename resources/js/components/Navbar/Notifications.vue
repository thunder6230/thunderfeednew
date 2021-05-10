<template>
<div :class="`bg-white border border-blue-200 rounded shadow-md absolute ${props.isDropdownOpen ? '' : 'hidden' }`">
    <ul>
        <Notification v-for="unReadNotification in props.unread_notifications" :key="unReadNotification.id" :unReadNotification="unReadNotification"/>
        <div class="py-1 px-2 bg-white text-center text-blue-700 hover:bg-blue-700 hover:text-white">
            <a :href="`/${props.user.username}/notifications`">All Notifications</a>
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