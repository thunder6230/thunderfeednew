@component('mail::message')
<h1>You have a new Friend!</h1>
<p>{{$user->name}} accepted your friendship. Click on the button to check {{$user->gender == "female" ? "her" : "his"}} profile!</p>

@component('mail::button', ['url' => route('profile', $user)])
Check Profile
@endcomponent

Thanks,<br>
ThunderFeed
@endcomponent
