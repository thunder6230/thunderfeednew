@component('mail::message')
<h1>You have a new Request!</h1>
<p>{{$user->name}} wants to be your Friend! Click on the button to check {{$user->gender == "female" ? "her" : "his"}} profile!</p>

@component('mail::button', ['url' => route('profile', $user)])
Check Profile
@endcomponent

Thanks,<br>
ThunderFeed
@endcomponent
