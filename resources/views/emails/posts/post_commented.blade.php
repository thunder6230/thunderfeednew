@component('mail::message')
<h1>Your Post has new Comment!</h1>
<p>{{$user->name}} has just commented to your Post. Click on the button to check it!</p>

@component('mail::button', ['url' => route('posts.show', $post)])
Check Post
@endcomponent

Thanks,<br>
ThunderFeed
@endcomponent
