<template>
    <div class="mt-20 flex flex-col w-full justify-center items-center">
        <h1>All Notifications</h1>
        <div v-if="user.notifications.length > 0">
            <Notification v-for="(notification,index) in user.notifications" :key="index" :user="user" :notification="notification"/>
        </div>
        <!-- @if ($userWithAllData->notifications->count() > 0)
            @foreach ($userWithAllData->notifications as $notification)
                @if ($notification->type == "App\Notifications\FriendRequestNotification")
                    <x-friend-request :notification='$notification' />
                @elseif ($notification->type == "App\Notifications\FriendRequestAcceptedNotification")
                    <x-friend-request :notification='$notification' />
                @else
                    <x-post-notification :notification='$notification' />
                @endif
                
                {{$notification->markAsRead()}}
            @endforeach
        @else    
            <h1>No notifications</h1>
        @endif -->
    </div>
</template>

<script>
import Notification from './Notification.vue'
export default {
    props: ['user'],
    data(){
        return {

        }
    },
    components: { Notification }
}
</script>

<style>

</style>