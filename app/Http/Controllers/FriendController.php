<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\FriendAccepted;
use Illuminate\Http\Request;
use App\Mail\FriendRequested;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\View\Components\FriendRequest;
use App\Notifications\FriendRequestNotification;
use App\Notifications\FriendRequestAcceptedNotification;

class FriendController extends Controller
{
    public function addFriend(User $user){
        // dd($user);
        Auth::user()->friends()->create([
            'friend_id' => $user->id
        ]);
        $user->friends()->create([
            'friend_id' => Auth::user()->id
        ]);
        Mail::to($user->email)->send(new FriendRequested(Auth::user()));
        $user->notify(new FriendRequestNotification(Auth::user()));
        return back();
    }

    public function acceptFriend(User $user){
        Auth::user()->friends()->where('friend_id', $user->id)->update(['accepted_at' => now()]);
        $user->friends()->where('friend_id', Auth::user()->id)->update(['accepted_at' => now()]);
        
        Mail::to($user->email)->send(new FriendAccepted(Auth::user()));
        $user->notify(new FriendRequestAcceptedNotification(Auth::user()));
        return back();
    }
    public function destroy(User $user){
        Auth::user()->friends()->where('friend_id', $user->id)->delete();
        $user->friends()->where('friend_id', Auth::user()->id)->delete();
        return back();
    }
}
