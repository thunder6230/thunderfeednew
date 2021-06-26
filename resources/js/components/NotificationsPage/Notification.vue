<template>
  <div class="w-full flex">
      <a :href="`/profile/${user.username}`"><img :src="`/storage/${user.pictures[user.pictures.length - 1].url}`" alt=""></a>
      <div>
          <a :href="`/profile/${user.username}`">{{user.name}}</a> {{notificationText}}
      </div>
  </div>
</template>

<script>
export default {
    props:['notification', 'user'],
    data(){
        return{
            notificationText: "",
            isFriendRequest: false,
            isFriendRequestAccepted: false,
            csrf: document.head.querySelector('meta[name="csrf-token"]').content,

            notificationTypes: {
                NEW_POST_TO_USER: "App\\Notifications\\NewPostToUserNotification",
                POST_LIKED: "App\\Notifications\\PostLikedNotification",
                COMMENT_LIKED: "App\\Notifications\\CommentLikedNotification",
                PICTURE_LIKED: "App\\Notifications\\PictureLikedNotification",

                POST_COMMENTED: "App\\Notifications\\PostCommentedNotification",
                PICTURE_COMMENTED: "App\\Notifications\\PictureCommentedNotification",
                COMMENT_REPLIED: "App\\Notifications\\CommentRepliedNotification",
                PICTURE_COMMENT_REPLIED: "App\\Notifications\\PictureCommentRepliedNotification",

                FRIEND_ACCEPTED: "App\\Notifications\\FriendRequestAcceptedNotification",
                NEW_FRIEND_REQUEST:"App\\Notifications\\FriendRequestNotification",
            }
        }
    },
     beforeMount(){
        // console.log(this.props.unreadNotification.type)
        this.prepareNotification(this.notification.type)
        
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
                case (this.notificationTypes.NEW_POST_TO_USER):
                    this.notificationText = "shared something to your wall!"
                    return
                case (this.notificationTypes.PICTURE_COMMENT_REPLIED):
                    this.notificationText = "replied to your comment!"
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
    }
}
</script>

<style>

</style>