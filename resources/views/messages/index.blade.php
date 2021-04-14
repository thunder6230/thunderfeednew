@extends('layout.app')


@section('content')
<div id="app" class="h-full w-full flex items-center justify-center" >
    <chat-app :user="{{ Auth::user() }}"></chat-app>
</div>

@endsection