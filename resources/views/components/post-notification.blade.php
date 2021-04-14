<a href="/posts/{{$notification->data['post']['id']}}">
    <div class="w-full rounded bg-white p-2 flex items-center my-2 border border-blue-100">
        <div class="mr-5">
            <img src="{{asset('storage/' . $notification->data['user']['profile_picture'])}}" alt="" class="w-20 rounded-full">
        </div>
        <div>
            <p><strong>{{$notification->data['user']['name']}}</strong> {{$text}}</p>
            <small>{{$notification->created_at->diffForHumans()}}</small>
        </div> 
    </div>
</a>