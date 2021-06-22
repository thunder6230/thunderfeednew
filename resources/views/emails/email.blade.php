@component('mail::message')
<h1>{{$title}}</h1>
<p>{{$message}}</p>

@component('mail::button', ['url' => route($route, $route_params)])
{{$buttonText}}
@endcomponent

Thanks,<br>
ThunderFeed
@endcomponent
