<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Friend;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;

class ContactController extends Controller
{
    public function getFriends(){
        // $contacts = $user->friends->friend_id;
        $contacts = [];
        foreach(Auth::user()->friends as $friend){
            $user = User::find($friend->friend_id);
            $contacts[] = $user;
        }
        dd(Message::all()->where('user_to_id', Auth::user()->id));


        return response()->json($contacts);
    }
    public function getAll(){
        // dd(Message::all()->where('user_to_id', Auth::user()->id));
        $users = User::all()->where('id', '!=', Auth::user()->id);

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
        return response()->json(
            User::where('id', '!=', Auth::user()->id)->with('picture')->get()
        );
    }
    
    
}
