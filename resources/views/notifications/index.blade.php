@extends('layout.app')

@section('content')
    <div class="mt-20">
        <h1>All Notifications</h1>
    
        @if ($user->notifications->count() > 0)
            @foreach ($user->notifications as $notification)
                @if ($notification->type == "App\Notifications\FriendRequestNotification")
                    <x-friend-request :notification='$notification' />
                @elseif ($notification->type == "App\Notifications\FriendRequestAcceptedNotification")
                    <x-friend-request :notification='$notification' />
                @else
                    <x-post-notification :notification='$notification' />
                @endif
                
                {{$notification->markAsRead()}}
            @endforeach
        @else    
            <h1>No notifications</h1>
        @endif

    </div>
@endsection