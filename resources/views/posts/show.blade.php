@extends('layout.app')

@section('content')

     <div id="app">
        <show-single-post user="{{$userWithAllData}}" post="{{$post}}"></show-single-post>
    </div>
@endsection

