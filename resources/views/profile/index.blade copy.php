@extends('layout.app')

@section('content')
<div class="container lg:w-8/12 m-auto">
    <div id="app">
        <profile-page :props=""></profile-page>
    </div>
            <div class="flex">
                <img src="{{asset('storage/' . $user->profile_picture)}}" alt="">
                <h1 class="text-2xl font-bold">{{$user->name}}</h1>
            </div>
            <div class="flex w-full mt-4" id="buttons">
                <button class="flex-1 bg-blue-700 text-white" data-role="posts">Posts</button>
                <button class="flex-1" data-role="profileDatas">Profile Datas</button>
                <button class="flex-1" data-role="images">Images</button>
            </div>
            {{-- This is for friend requests but i still need to improve --}}
            @auth
                @if(Auth::user() != $user)
                    @if (Auth::user()->isMyFriend($user)->count() != 0)
                        <form action="{{route('user.friend.delete', $user)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Unfriend</button>
                        </form>
                    @else
                        <form action="{{route('user.friend.add', $user)}}" method="POST">
                            @csrf
                            <button type="submit">Add Friend</button>
                        </form>
                    @endif
                @endif
            @endauth
    
            <div id="datasContainer">
                Datas
            </div>
            <div id="imagesContainer">
                Images
            </div>
            <div id="postsContainer">
                @if ($user->posts->count() > 0)
                    @foreach ($user->posts->reverse() as $post)
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
