@extends('layout.app')

@section('content')
        <div class="container lg:w-8/12 m-auto">
            @auth
                <form action="{{route('posts')}}" method="POST" enctype="multipart/form-data" class="flex-col">
                    @csrf
                    <textarea name="body" id="body" cols="30" rows="2" class="w-full border border-blue-200 rounded-xl p-4 mt-4" placeholder="What's in you mind?"></textarea>
                    <div class="flex justify-between">
                        <label for="image" class="cursor-pointer bg-blue-700 p-2 rounded text-white text-md"><i class="fas fa-image"></i> Add Photo</label>
                        <input type="file" name="image" id="image" class="hidden">
                        <button type="submit" class="bg-blue-700 px-4 py-2 rounded text-white">Post</button>
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
            <div class="mt-4">
                @if ($posts->count() > 0)
                    @foreach ($posts as $post)
                        <x-post :post="$post" />
                    @endforeach
                @else
                    <div class="mt-2 bg-white p-4 rounded-md">
                        <p class="text-xl">There are no Posts yet</p>
                    </div>
            
                @endif
            </div>
        </div>
@endsection

<script>
    
    document.addEventListener('DOMContentLoaded', () => {
        const postContainers = document.querySelectorAll('#postContainer')
        
        postContainers.forEach(post => post.addEventListener('click', (e) => {
            if(e.target.getAttribute('id') == "showCommentsBtn") {
                post.querySelector('#postComments').classList.toggle('hidden')
            }
        }))
    })
</script>