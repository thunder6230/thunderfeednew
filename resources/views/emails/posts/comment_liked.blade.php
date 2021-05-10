@component('mail::message')
<h1>Your Comment got liked!</h1>
<p>{{$user->name}} liked your Comment. Click on the button to check it!</p>

@component('mail::button', ['url' => route('posts.show', $post)])
Check Post
@endcomponent

Thanks,<br>
ThunderFeed
@endcomponent
