@props(['comment' => $comment])

<div class="flex justify-between">
    <div class="flex">
        <a href="{{route('profile', $comment->user)}}"><img src="{{asset('storage/' . $comment->user->profile_picture) }}" alt="" class="rounded-full w-8 mr-2"></a>
        <a href="{{route('profile', $comment->user)}}">{{$comment->user->name}}</a>
    </div>
        @if (Auth::user() == $comment->user)
            {{-- edit function later --}}
            <form action="{{route('posts.comment.delete', $comment)}}" method="POST" class="mb-0">
                @csrf
                @method('DELETE')
                <button type="submit"><i class="far fa-times-circle text-red-500"></i></button>
            </form>
         @endif
</div>
<div class="">
    <p>{{$comment->body}}</p>
    @if ($comment->comment_picture != NULL)
        <img src="{{asset('storage/' . $comment->comment_picture) }}" alt="" class="rounded w-auto mr-2">
    @endif
</div>