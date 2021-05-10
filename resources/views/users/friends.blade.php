@extends('layout.app')

@section('content')
<div id="app" class="container lg:w-8/12  m-auto">
    <friends-page user="{{$userWithAllData}}"></friends-page>
</div>
@endsection