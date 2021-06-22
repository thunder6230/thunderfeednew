<template>
  <!-- <li class="text-black"><a :href="`/posts/${postData.id}`">Notification</a></li> -->
  <div class="text-black border-b border-blue-200 w-full hover:bg-blue-100 cursor-pointer" @click="openNotificationEvent(props.unreadNotification.data)">
    <div class="flex">
        <div class="p-1 flex items-center justify-center w-full">
            <div class="mr-2 w-1/5">
                    <a :href="`/profile/${props.unreadNotification.data.user.username}`"><img :src="`/storage/${props.unreadNotification.data.user.picture.url}`" class="w-12 rounded-full"/></a>
            </div>
            <div class="text-sm flex-grow w-full">
                <p><span class="font-d font-bold">{{props.unreadNotification.data.user.name}}</span> {{notificationText}}</p>
                <small class="text-gray-500"><vue-moments-ago v-bind:date="props.unreadNotification.created_at" prefix="" affix="" elementStyle="font-size: 10px; line-height: 1"></vue-moments-ago></small>
            </div>
            <div class="text-blue-700 p-2 cursor-pointer flex items-center justify-center w-1/5" v-if="isFriendRequest && !isFriendRequestAccepted" @click.stop="acceptFriend">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import VueMomentsAgo from 'vue-moments-ago'
export default {
    props: ['props'],
    data(){
        return{
            notificationText: "",
            isFriendRequest: false,
            isFriendRequestAccepted: false,
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,

            notificationTypes: {
                POST_LIKED: "App\\Notifications\\PostLikedNotification",
                COMMENT_LIKED: "App\\Notifications\\CommentLikedNotification",
                PICTURE_LIKED: "App\\Notifications\\PictureLikedNotification",

                POST_COMMENTED: "App\\Notifications\\PostCommentedNotification",
                PICTURE_COMMENTED: "App\\Notifications\\PictureCommentedNotification",
                COMMENT_REPLIED: "App\\Notifications\\CommentRepliedNotification",

                FRIEND_ACCEPTED: "App\\Notifications\\FriendRequestAcceptedNotification",
                NEW_FRIEND_REQUEST:"App\\Notifications\\FriendRequestNotification",
            }

        }
    },
    beforeMount(){
        // console.log(this.props.unreadNotification.type)
        this.prepareNotification(this.props.unreadNotification.type)
        
    },
    mounted(){
        if(this.isFriendRequest){
            setTimeout(() => this.checkIfFriendshipAccepted(),100)
        }
    },
    methods:{
        prepareNotification(notificationType){
            switch(notificationType){
                //post notifications
                case (this.notificationTypes.POST_LIKED):
                    this.notificationText = "liked your Post!"
                    return
                case (this.notificationTypes.POST_COMMENTED):
                    this.notificationText = "commented to your Post!"
                    return
                //friendrequest notifications
                case (this.notificationTypes.NEW_FRIEND_REQUEST):
                    this.isFriendRequest = true
                    this.notificationText = "wants to be your friend!"
                    return
                case (this.notificationTypes.FRIEND_ACCEPTED):
                    this.notificationText = "is now your friend!"
                    return
                //comment notifications
                case (this.notificationTypes.COMMENT_LIKED):
                    this.notificationText = "liked your Comment!"
                    return
                case (this.notificationTypes.COMMENT_REPLIED):
                    this.notificationText = "replied to your Comment!"
                    return
                //picture notifications
                case (this.notificationTypes.PICTURE_LIKED):
                    this.notificationText = "liked your Picture!"
                    return
                case (this.notificationTypes.PICTURE_COMMENTED):
                    this.notificationText = "commented to your Picture!"
                    return
            }
        },
        checkIfFriendshipAccepted(){
            this.props.user.friend_of.forEach(friend => {
                // console.log(friend.id == this.props.unreadNotification.data.user.id)
                
                if(friend.id == this.props.unreadNotification.data.user.id){
                    console.log(friend)
                    if(friend.pivot.accepted_at != null){
                        console.log(friend)
                        console.log('yes')
                        return this.isFriendRequestAccepted = true
                    }
                    return this.isFriendRequestAccepted = false
                }
            })
        },
        openNotificationEvent(data){

            if(data.post){
                return window.location.href = `/posts/${data.post.id}`
            }
            return window.location.href = `/profile/${data.user.username}`
        },
        acceptFriend(){
            
        const params = {
            '_token': this.csrf,
            'user_id': this.props.unreadNotification.data.user.id
        }
        axios.post(`/api/acceptfriend`, params)
            .then(resp =>  {
                this.isFriendRequestAccepted = true 
                alert('You have a new Friend!')
            }) 
            .catch(error => console.log(error.response))
        },
    },
    components: {VueMomentsAgo}
}
</script>

<style>
</style>