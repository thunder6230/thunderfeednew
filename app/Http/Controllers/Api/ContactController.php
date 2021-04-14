<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function get(User $user){
        // $contacts = $user->friends->friend_id;
        $contacts = [];
        foreach($user->friends as $friend){
            $user = User::find($friend->friend_id);
            $contacts[] = $user;
        }
        return response()->json($contacts);
    }
    public function getAll(){
        
        return response()->json(User::all());
    }
    
}
