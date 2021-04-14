@extends('layout.app')

@section('content')

    <div class="container lg:w-8/12 m-auto">
        <x-post :post="$post" />
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const postContainers = document.querySelectorAll('#postContainer')
        postContainers.forEach(post => post.addEventListener('click', (e) => {
            if(e.target.getAttribute('id') == "showCommentsBtn") {
                post.querySelector('#postComments').classList.toggle('hidden')
            }
        }))
    })
</script>