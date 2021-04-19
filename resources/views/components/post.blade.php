@props(['post' => $post])

<div class="mt-2 rounded-xl p-2 bg-white border border-blue-200" id="postContainer">
    <div class="flex justify-between">
        <div class="flex">
            
            <a href="{{route('profile', $post->user)}}">
                <img src="{{asset('storage/' . $post->user->profile_picture) }}" alt="" class="rounded-full w-10 mr-2">
            </a>
            <div>
                <a href="{{route('profile', $post->user)}}">{{$post->user->name}}</a>
                <p class="text-sm text-gray-500">{{$post->created_at->diffForHumans()}}</p>
            </div>
        </div>
        @if ($post->user == Auth::user())
            <form method="POST" action="{{route('posts.delete', $post)}}">
                @csrf
                @method('DELETE')
                <button type="submit"><i class="far fa-times-circle text-red-500"></i></button>
            </form>
        @endif
    </div>
    <p>{!! ($post->body) !!}</p>
    <img src="{{ asset('storage/' . $post->image_path)  }}" alt="" class="rounded">
    <div class="flex justify-around">
        <p>{{ $post->likes()->count()}} {{Str::plural('Like', $post->likes()->count())}}</p>
        <p>{{ $post->postComments()->count()}} {{Str::plural('Comment', $post->postComments()->count())}}</p>
    </div>
    @auth
        <div class="flex items-center">
                @if (!$post->userLiked(Auth::user())  )
                    <form action="{{route('posts.likes', $post)}}" method="POST" class="mb-0 flex-1 flex">
                        @csrf
                        <button type="submit" class="flex-1">Like</button>
                    </form>
                @else
                    <form action="{{route('posts.likes', $post)}}" method="POST" class=" mb-0 flex-1 m-auto flex">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex-1">Unlike</button>
                    </form>
                @endif
                <button class="flex-1" id="showCommentsBtn">Show Comments</button>
        </div>
    @endauth
    {{-- Post Comment --}}
    <div class="w-full hidden" id="postComments">
        @foreach ($post->postComments as $comment)
            <x-post-comments :comment="$comment" />            
        @endforeach
    </div>
    @auth
        <form action="{{route('posts.comment', $post)}}" method="POST" enctype="multipart/form-data" class="flex-col">
            @csrf
            <textarea name="comment_body" id="comment_body" cols="30" rows="1" class="w-full border border-blue-200 rounded-xl p-4 mt-4" placeholder="Your comment"></textarea>
            <div class="flex justify-between">
                <label for="comment_image" class="cursor-pointer bg-blue-700 p-2 rounded text-white text-md"><i class="fas fa-image"></i>Add Photo</label>
                <input type="file" name="comment_image" id="comment_image" class="hidden">
                <button type="submit" class="bg-blue-700 px-4 py-2 rounded text-white">Send Comment</button>
            </div>
            @error('image')
                <div class="text-red-500">
                    {{ $message }}
                </div>
            @enderror
            @error('body')
                <div class="text-red-500">
                    {{ $message }}
                </div>
            @enderror
        </form>
    @endauth

</div>