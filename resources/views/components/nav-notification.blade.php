<div class="notification text-black border-b border-blue-200">
    @if(Str::contains(Str::lower($notification->type), "friendrequest"))
    <a href="/profile/{{$notification->data['user']['username']}}" class="">
            <div class="flex">
                <div class="p-1 flex">
                    <div class="imageDiv mr-2">
                        <img src="{{asset('storage/' . $notification->data['user']['picture']['url'])}}"
                            class="w-8 mt-1 rounded-full" alt="">
                    </div>
                    <div class="text-xs">
                        <strong class="mr-2">{{$notification->data['user']['name']}}</strong>
                        <p>{{$text}}</p>
                        <small class="text-gray-500">{{$notification->created_at->diffForHumans()}}</small>
                    </div>
                </div>
                <div>
                    <form action="/profile/{{$notification->data['user']['id']}}/accept" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-700 p-2">Accept</button>
                    </form>
                </div>
            </div>
        </a>
    @else
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
    @endif
</div>

