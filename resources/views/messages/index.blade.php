@extends('layout.app')


@section('content')
<div id="app" class="w-full h-full flex items-center justify-center" >
    <chat-app :user="{{ $userWithAllData }}"></chat-app>
</div>

@endsection