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

<body class="min-h-screen bg-gray-50 w-full h-full box-border">
    <div id="navbar" class="bg-blue-700 p-4 text-white items-center fixed w-full top-0 z-40 h-14">
        <navbar :user="{{$userWithAllData}}" isMessages="{{ isset($isMessages) }}"></navbar>
    </div>

    <div class="container xs:w-11/12 sm:w-10/12 md:w-9/12 lg:w-8/12 xl:w-8/12 2xl:w-8/12 mt-16 mx-auto min-h-3/4 h-5/6">
        @yield('content')
    </div>
</body>
<script>
</script>
</html>
