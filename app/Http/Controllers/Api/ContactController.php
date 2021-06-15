<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Friend;
use App\Models\Message;
use Illuminate\Http\Request;
use function PHPSTORM_META\map;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function getFriends(){
        // $contacts = $user->friends->friend_id;
        // foreach(Auth::user()->friends as $friend){
        //     $user = User::find($friend->friend_id);
        //     $contacts[] = $user;
        // }
        // dd(Message::all()->where('user_to_id', Auth::user()->id));
        $contacts = Auth::user()->friends()->with('picture')->get();
        foreach(Auth::user()->friendOf()->with('picture')->get() as $user){
            $contacts[] = $user;
        }
        if(empty($contacts)){
            return response("There are no Friends yet!");
        }
        return response()->json($contacts);
    }
    public function getAll(){
        // dd(Message::all()->where('user_to_id', Auth::user()->id));
        $users = User::all()->where('id', '!=', Auth::user()->id)->with('picture');

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
            User::where('id', '!=', $id)->with('picture')->get()
        );
    }

    public function store(Request $request){
        $friend_id = $request->user_id;
        Auth::user()->friends()->attach($friend_id);
        return response($friend_id);    
    }

    public function update(Request $request){

        $friend_id = $request->user_id;
        $friendship = Auth::user()->friendOf()->where('user_id', $friend_id)->first();
        
        if(!$friendship->pivot->update(['accepted_at' => now()])){
            return response("Error", 500);
        }
        return response($friend_id);  
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
