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
    /**
     * When we add a friend we send an email and a notification to the user. For the moment i duplicate the entries in both ways to make Eloquent relationship easier but i will rewrite this logic. the accepted_at gonna be default null. that value is going to change after accept request. I send a notification and email to the user.
     */
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
    /**
     * We add a timestamp to  both entries to be confirmed and send email and notification to the user.
     */
    public function acceptFriend(User $user){
        Auth::user()->friends()->where('friend_id', $user->id)->update(['accepted_at' => now()]);
        $user->friends()->where('friend_id', Auth::user()->id)->update(['accepted_at' => now()]);
        
        Mail::to($user->email)->send(new FriendAccepted(Auth::user()));
        $user->notify(new FriendRequestAcceptedNotification(Auth::user()));
        return back();
    }
    /**
     * Delete both entries from the friends table
     */
    public function destroy(User $user){
        Auth::user()->friends()->where('friend_id', $user->id)->delete();
        $user->friends()->where('friend_id', Auth::user()->id)->delete();
        return back();
    }
}
