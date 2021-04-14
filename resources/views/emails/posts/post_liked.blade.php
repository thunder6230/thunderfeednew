@component('mail::message')
<h1>Your Post got liked!</h1>
<p>{{$user->name}} liked your Post. Click on the button to check it!</p>

@component('mail::button', ['url' => route('posts.show', $post)])
Check Post
@endcomponent

Thanks,<br>
ThunderFeed
@endcomponent
