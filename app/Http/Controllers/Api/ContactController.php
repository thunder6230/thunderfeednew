<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function get(){
        // $contacts = $user->friends->friend_id;
        $contacts = [];
        foreach(Auth::user()->friends as $friend){
            $user = User::find($friend->friend_id);
            $contacts[] = $user;
        }


        return response()->json($contacts);
    }
    public function getAll(){
        
        return response()->json(User::all()->where('id', '!=', Auth::user()->id));
    }
    
}
