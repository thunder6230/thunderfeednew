<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getMessages(User $user){
        $messages = Message::select()->where('user_to_id', $user->id)->orWhere('user_id', $user->id)->get();
        return response()->json($messages);
    }

    public function store(Request $request){
        $message = Message::create([
            'user_id' => Auth::user()->id,
            'user_to_id' => $request->contact,
            'body' => $request->text
        ]);
        if(!$message){
            return response("error", 500);
        }   
        return response()->json($message);
    }
    
}
