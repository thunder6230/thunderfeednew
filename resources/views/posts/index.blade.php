@extends('layout.app')

@section('content')
<div id="app" class="container 2xl:w-10/12 m-auto">
    @auth
    <posts-app :user="{{ Auth::user() }}"></posts-app>
    @endauth
    @guest
        <posts-app></posts-app>
    @endguest    
</div>
@endsection
