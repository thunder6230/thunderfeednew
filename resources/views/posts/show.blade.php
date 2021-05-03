@extends('layout.app')

@section('content')

     <div id="app">
        <show-single-post :props='@json($laravelCollection)'></show-single-post>
    </div>
@endsection

