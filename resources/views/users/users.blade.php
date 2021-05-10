@extends('layout.app')

@section('content')
<div id="app" class="container lg:w-8/12  m-auto">
    <users-page user="{{$userWithAllData}}"></users-page>
</div>
@endsection