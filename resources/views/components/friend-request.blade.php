<a href="/profile/{{$notification->data['user']['username']}}">
    <div class="w-full rounded bg-white p-2 flex items-center my-2 border border-blue-100">
        <div class="mr-5">
            <img src="{{asset('storage/' . $notification->data['user']['profile_picture'])}}" alt="" class="w-20 rounded-full">
        </div>
        <div >
            <p><strong>{{$notification->data['user']['name']}}</strong> {{$text}}</p>
            <small>{{$notification->created_at->diffForHumans()}}</small>
        </div>
        @if(!Auth::user()->isMyAcceptedFriendById($notification->data['user']['id']))
            <div class="w-full flex-1 ml-10">
                <form action="/profile/{{$notification->data['user']['id']}}/accept" method="POST" class="flex justify-center">
                    @csrf
                    <button type="submit" class="bg-blue-700 px-4 py-2 text-white rounded hover:bg-blue-900">Accept Friend</button>
                </form>
            </div>
        @endif
    </div>
</a>