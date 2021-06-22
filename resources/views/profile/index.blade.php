@extends('layout.app')

@section('content')
    <div id="app" class="container lg:w-8/12  m-auto">
        <profile-page :profile="{{$profileWithAllData}}" :user="{{$userWithAllData}}" :picture="{{$pictureId}}"></profile-page>
    </div>
@endsection
