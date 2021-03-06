<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Friend;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Mail\FriendRequested;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\FriendAccepted;
use App\Notifications\FriendRequestAcceptedNotification;
use App\Notifications\FriendRequestNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function getfriends(){
        // $contacts = $user->friends->friend_id;
        // foreach(Auth::user()->friends as $friend){
        //     $user = User::find($friend->friend_id);
        //     $contacts[] = $user;
        // }
        
        $contacts = Auth::user()->friends()->with('pictures')->get();
        $friendof = Auth::user()->friendof()->with('pictures')->get();
        foreach($friendof as $user){
            $contacts[] = $user;
        }
        $unreadMessages = Message::select(DB::raw('user_id, count(*) as messages_count'))
            ->where('user_to_id', Auth::user()->id)
            ->where('read_at', null)
            ->groupBy('user_id')->get();

        $contacts = $contacts->map(function ($contact) use ($unreadMessages) {
            $unreadFromUser = $unreadMessages->where('user_id', $contact->id)->first();

            $contact->unread = $unreadFromUser ? $unreadFromUser->messages_count : 0;
            return $contact;
        });   
        if(empty($contacts)){
            return response("There are no contacts yet!");
        }
        return response()->json($contacts);
    }
    // public function getFriends(){
    //     $friends = Auth::user()->friends()->with('picture');
    //     $friendof = Auth::user()->friendOf()->with('picture');
    //     dd($friendof);
    //     $unreadMessages = Message::select(DB::raw('user_id, count(*) as messages_count'))
    //     ->where('user_to_id', Auth::user()->id)
    //         ->where('read_at', null)
    //         ->groupBy('user_id')->get();

    //     $friends = $friends->map(function ($friend) use ($unreadMessages) {
    //         $unreadFromUser = $unreadMessages->where('user_id', $friend->id)->first();

    //         $friend->unread = $unreadFromUser ? $unreadFromUser->messages_count : 0;
    //         return $friend;
    //     });

    //     return response()->json($friends);
    // }
    public function getAll(){
        // dd(Message::all()->where('user_to_id', Auth::user()->id));
        $users = User::all()->where('id', '!=', Auth::user()->id)->with('pictures');

        $unreadMessages = Message::select(DB::raw('user_id, count(*) as messages_count'))
            ->where('user_to_id', Auth::user()->id)
            ->where('read_at', null)
            ->groupBy('user_id')->get();

        $users = $users->map(function($user) use ($unreadMessages){
            $unreadFromUser = $unreadMessages->where('user_id', $user->id)->first();
            
            $user->unread = $unreadFromUser ? $unreadFromUser->messages_count : 0;
            return $user;
        });

        return response()->json($users);
       
    }
    public function getAllUsers(){
        // dd(User::all());
        $id = Auth::user()->id ?? -1;
        return response()->json(
            User::where('id', '!=', $id)->with('pictures')->get()
        );
    }

    public function store(Request $request){

        $friend = User::find($request->user_id);
        Auth::user()->friends()->attach($friend->id);
        Mail::to($friend->email)->send(new FriendRequested(Auth::user()));
        $friend->notify(new FriendRequestNotification(User::with('pictures')->find(Auth::user()->id)));
        return response($friend->id);    
    }

    public function update(Request $request){
        $friend = User::find($request->user_id);
        $friendship = Auth::user()->friendOf()->where('user_id', $friend->id)->first();
        if(!$friendship->pivot->update(['accepted_at' => now()])){
            return response("Error", 500);
        }
        Mail::to($friend->email)->send(new FriendAccepted(Auth::user()));
        $friend->notify(new FriendRequestAcceptedNotification(User::with('pictures')->find(Auth::user()->id)));
        return response($friend->id);  
    }
    
    public function destroy(Request $request){

        $friend_id = $request->user_id;
        $myFriends = Auth::user()->friends()->where('friend_id', $friend_id);
        $FriendOf = Auth::user()->friendOf()->where('user_id', $friend_id);
        if($myFriends->first() != null){
            Auth::user()->friends()->detach(['friend_id', $friend_id]);
            return response($friend_id);
        }
        if($FriendOf->first() != null){
            Auth::user()->friendOf()->detach(['user_id', $friend_id]);
            return response($friend_id);
        }
        return response("There is no Friendship data", 500);
        
    }
    
    
}
