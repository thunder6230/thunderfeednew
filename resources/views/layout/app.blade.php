<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ThunderFeed</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    
    <script defer src="{{ asset('js/app.js') }}"></script>

</head>

<body class="min-h-screen bg-yellow-50 w-full absolute h-full box-border">
    <nav class="flex justify-between bg-blue-700 px-4 py-4 text-white items-center fixed w-full top-0 h-13">
        <ul class="flex px-2">
            <li><a href="{{route('home')}}" class="mr-3">Home</a></li>
            <li><a href="{{route('posts')}}" class="mr-3">Posts</a></li>
            <li><a href="#" class="mr-3">Contact</a></li>
            <li><a href="#" class="mr-3">About</a></li>
            @auth
            <li>
                <div class="relative mr-3">

                    <a href="{{route('user.messages', Auth::user())}}">Messages</a>


                    @if ( $unreadMessages > 0)
                        <div class="notificationLabel">
                            <p class="labelContent">{{$unreadMessages}}</p>
                        </div>
                    @endif
                </div>
            </li>
            <li>
                @if (Auth::user()->unreadNotifications->count() > 0)
                    <div class="relative">
                        <button id="notificationBtn">Notifications</button>
                        <div class="notificationDiv bg-white border border-blue-200 rounded shadow-md hidden" id="notificationDiv">
                            @foreach (Auth::user()->unreadNotifications as $notification)
                                    <x-nav-notification :notification="$notification" />
                            @endforeach
                            <div class="py-1 px-2 bg-white text-center text-blue-700 hover:bg-blue-700 hover:text-white">
                                <a href="{{route('user.notifications', Auth::user())}}">All Notifications</a>
                            </div>
                        </div>
                        <div class="notificationLabel">
                            <p class="labelContent">{{Auth::user()->unreadNotifications->count()}}</p>
                        </div>
                    </div>
                @else
                    <a href="{{route('user.notifications', Auth::user())}}">Notifications</a>
                @endif
            </li>
            @endauth
        </ul>

        <ul class="flex px-2 items-center">
            @auth
            <li class="mr-3">
                <a href="{{route('profile', Auth::user())}}">
                    <div class="flex mr-3 justify-center items-center">
                            <img src="{{asset('storage/' . Auth::user()->profile_picture)}}" alt="" class="rounded-full w-7 mr-2">
                        {{Auth::user()->name}}
                    </div>
                </a>
            </li>
            <li><a href="{{route('logout')}}" class="mr-3">Logout</a></li>

            @endauth
            @guest
            <li><a href="{{route('login')}}" class="mr-3">Login</a></li>
            <li><a href="{{route('register')}}" class="mr-3">Register</a></li>
            @endguest
        </ul>
    </nav>
    {{-- <nav>Mobile Menu</nav> --}}

    <div class="container xs:w-11/12 sm:w-10/12 md:w-9/12 lg:w-8/12 xl:w-8/12 2xl:w-6/12 mt-16 mx-auto min-h-3/4 h-5/6">
        @yield('content')
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const notificationButton = document.getElementById('notificationBtn')
        if(notificationButton){
            notificationButton.addEventListener('click', (e) => {
                e.target.parentElement.querySelector('#notificationDiv').classList.toggle('hidden');
            })
        }
    })
</script>

</html>
