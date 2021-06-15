@extends('layout.app')

@section('content')

     <div id="app">
        <show-single-post user="{{$userWithAllData}}" post_id="{{$post_id}}"></show-single-post>
    </div>
@endsection

