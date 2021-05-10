@extends('layout.app')

@section('content')
<div id="app" class="container 2xl:w-10/12 m-auto">
    <posts-app :user="{{$userWithAllData}}"></posts-app>
</div>
@endsection
