@extends('layout.app')


@section('content')
<div id="app" class="w-screen absolute left-0 flex items-center justify-center" style="height: calc(100vh - 5em);">
    <chat-app :user="{{ $userWithAllData }}"></chat-app>
</div>

@endsection