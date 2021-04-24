<template>
  <div>
      <div class="flex items-start relative pb-2">
        <div class="mr-2 flex-none">
            <a :href="`/profile/${props.comment.user_id}`">
                <img :src="`/storage/${props.comment.user.profile_picture}`" alt="" class="rounded-full w-8">
            </a>
        </div>
        <div class="bg-gray-100 px-2 pt-1 pb-2 rounded-lg">
            <div>
                <a :href="`/profile/${props.comment.user_id}`" class="text-sm font-medium">{{props.comment.user.name}}</a>
                <vue-moments-ago prefix="" suffix="ago" v-bind:date="props.comment.created_at" lang="en" class="ml-5"></vue-moments-ago>  

            </div>
            
            <div>
                <p class="text-md leading-3">{{props.comment.body}}</p>
                <img v-if="props.comment.comment_picture != null" :src="`storage/${props.comment.comment_picture}`" alt="" class="rounded w-auto mr-2 pt-2">
            </div>
        </div>
        <form action="#" method="POST" class="mb-0 absolute right-0 top-0"
            v-if="props.user.id == props.comment.user_id">
            <input type="hidden" name="_token" :value="props.csrf">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit">
                <i class="far fa-times-circle text-red-500"></i>
            </button>
        </form>
      </div>
  </div>
</template>

<script>
import VueMomentsAgo from 'vue-moments-ago'
export default {
    props: ['props'],
    components: {VueMomentsAgo}
}
</script>

<style>

</style>