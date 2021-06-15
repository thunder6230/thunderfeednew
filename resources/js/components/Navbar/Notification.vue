<template>
  <!-- <li class="text-black"><a :href="`/posts/${postData.id}`">Notification</a></li> -->
  <div class="text-black border-b border-blue-200 w-full hover:bg-blue-100" @click="openPost(props.id)">
    <div class="flex">
        <div class="p-1 flex items-center justify-center w-full">
            <div class="mr-2 w-2/5">
                <!-- <img :src="`/storage/${props.data.user.picture.url}`"
                    class="w-8 mt-1 rounded-full" alt=""> -->
                    <img src="/storage/profile_pictures/male_default.jpg" class="w-12 rounded-full"/>
            </div>
            <div class="text-sm flex-grow w-full">
                <p class="font-d font-bold">{{postUser.name}}</p>
                <p class="leading-3">{{notificationText}}</p>
                <small class="text-gray-500"><vue-moments-ago v-bind:date="props.created_at" prefix="" affix="" elementStyle="font-size: 10px; line-height: 1"></vue-moments-ago></small>
            </div>
            <div class="text-blue-700 p-2 cursor-pointer flex items-center justify-center w-1/5" v-if="isFriendRequestAccepted">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
    </div>
    <!-- @else
        <a href="/posts/{{$notification->data['post']['id']}}" class="">
            <div class="p-1 flex">
                <div class="imageDiv mr-2">
                    <img src="{{asset('storage/' . $notification->data['user']['profile_picture'])}}"
                        class="w-8 mt-1 rounded-full" alt="">
                </div>
                <div class="text-xs">
                    <strong class="mr-2">{{$notification->data['user']['name']}}</strong>
                    <p>{{$text}}</p>
                    <small class="text-gray-500">{{$notification->created_at->diffForHumans()}}</small>
                </div> 
            </div>
        </a>
    @endif -->
</div>
</template>

<script>
import VueMomentsAgo from 'vue-moments-ago'
export default {
    props: ['props'],
    data(){
        return{
            postData: {},
            postUser: {},
            notificationText: "",
            isFriendRequest: false,
            isFriendRequestAccepted: false,
            notificationTypes: {
                POST_LIKED: "App\\Notifications\\PostLikedNotification",
                COMMENT_LIKED: "App\\Notifications\\PostLikedNotification",
                REPLY_LIKED: "App\\Notifications\\PostLikedNotification",
                PICTURE_LIKED: "App\\Notifications\\PostLikedNotification",

                POST_COMMENTED: "App\\Notifications\\PostCommentedNotification",
                PICTURE_COMMENTED: "App\\Notifications\\PictureCommentedNotification",
                COMMENT_REPLIED: "App\\Notifications\\PostCommentedNotification",

                FRIEND_ACCEPTED: "App\\Notifications\\FriendRequestAcceptedNotification",
                NEW_FRIEND_REQUEST:"App\\Notifications\\FriendRequestNotification",
            }

        }
    },
    beforeMount(){
        
        this.postData = this.props.data.post,
        this.postUser = this.props.data.user,
        this.prepareNotification()
    },
    methods:{
        prepareNotification(){
            console.log(this.notificationTypes.POST_LIKED)
            switch(this.props.type){
                case (this.notificationTypes.POST_LIKED):
                    this.notificationText = "liked your Post!"
                    return
                case (this.notificationTypes.POST_COMMENTED):
                    this.notificationText = "commented to your Post!"
                    return
                case (this.notificationTypes.NEW_FRIEND_REQUEST):
                    this.notificationText = "wants to be your friend!"
                    this.checkIfFriendshipAccepted()
                    return
            }
        },
        checkIfFriendshipAccepted(){
            this.props.user.friend_of.forEach(friendship => {
                if(friendship.id == this.postUser.id){
                    this.isFriendRequestAccepted = friendship.pivot.accepted_at != null ? true : false
                    return
                }
            })
        },
        openPost(){
            //mark notification as read
            axios.post(``)
            //redirect to the post
            window.location.href = `/posts/${this.postData.id}`
        }
    },
    components: {VueMomentsAgo}
}
</script>

<style>
</style>