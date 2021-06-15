<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ThunderFeed</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    
    <script defer src="{{ asset('js/app.js') }}"></script>

</head>

<body class="min-h-screen bg-gray-50 w-full h-full box-border overflow-x-hidden ">
    <div id="navbar" class="bg-blue-700 p-4 text-white items-center fixed w-full top-0 z-40 h-14">
        <navbar :user="{{$userWithAllData}}" isMessages="{{ isset($isMessages) }}"></navbar>
    </div>

    <div class="w-full h-96 bg-blue-700 flex items-center justify-center">
        <div class="flex w-full h-full relative">
            <div class="absolute left-0 bottom-0">
                <img src="/storage/logos/lightning_logo.svg" alt="" class="h-80">
                <h1 class="absolute bottom-8 text-3xl font-medium text-yellow-500 text-outline outline -">Thunderfeed</h1>
            </div>
            <h1 class="text-xl absolute inset-y-2/4 right-1/3">Why is Thunderfeed just a good Site?</h1>
        </div>
    </div>
    <div class="flex flex-col w-8/12 mx-auto  my-8 justify-between">
        <div class="flex justify-around my-8">

            <div class="w-3/12 flex-col items-center">
                <h2 class="font-bold text-lg text-center mb-2">Look For Your Friends!</h2>
                <p class="text-center">Look for your friends and relatives or invite them to grow our community!</p>
            </div>
            <div class="w-3/12 flex-col items-center mb-2">
                <h2 class="font-bold text-lg text-center mb-2">Real time Chat</h2>
                <p class="text-center">We built a real time chat app for you to talk smooth with each other </p>
            </div>
            <div class="w-3/12 flex-col items-center mb-2">
                <h2 class="font-bold text-lg text-center mb-2">Share Posts and Pictures</h2>
                <p class="text-center">You can share anything you want like Pictures, Ideas your favourites with just one Click!</p>
            </div>
        </div>
        <div class="w-full flex-col justify-center align-center">
            <h2 class="text-center font-medium text-5xl mt-4">Technologies I used</h2>
            <div class="flex w-12/12 m-auto justify-around my-16">
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/HTML5.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">HTML 5</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/php.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">PHP</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/laravel.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">Laravel</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/pusher.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">Pusher Websocket</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/phpmyadmin.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">PHP MyAdmin</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/mysql.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">MySql</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/vuejs.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">Vue.JS</p>
                </div>
                <div class="flex justify-center items-center flex-col">
                    <img src="/storage/logos/tailwindcss.svg" alt="" class="h-16">
                    <p class="font-medium text-lg mt-2">Tailwind CSS</p>
                </div>
            </div>
        </div>
    </div>
    <div class="w-screen h-96 bg-blue-700">
        <h1>Start Your Journey NOW</h1>
        <button>Register</button>
        <button>Login</button>
    </div>
</body>
<script>
</script>
</html>