@extends('layout.app')

@section('content')
<div id="app">
    <posts-app :user="{{Auth::user()}}"></posts-app>
</div>
@endsection

{{-- <script>
    
    document.addEventListener('DOMContentLoaded', () => {
        const postContainers = document.querySelectorAll('#postContainer')
        
        postContainers.forEach(post => post.addEventListener('click', (e) => {
            if(e.target.getAttribute('id') == "showCommentsBtn") {
                post.querySelector('#postComments').classList.toggle('hidden')
            }
        }))
    })
</script> --}}