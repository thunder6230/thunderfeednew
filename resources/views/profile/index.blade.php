@extends('layout.app')

@section('content')
    <div id="app" class="container lg:w-8/12  m-auto">
        <profile-page :users='@json($users)'></profile-page>
    </div>
@endsection
