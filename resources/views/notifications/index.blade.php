@extends('layout.app')

@section('content')
    <div id="app">
        <notifications-page :user="{{$userWithAllData}}"></notifications-page>

    </div>
@endsection