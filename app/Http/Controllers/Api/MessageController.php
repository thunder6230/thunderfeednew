<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function getMessages(User $user){
    
        //Query to get all the messages between the sleected and logged in user
        $messages = Message::select()->where( function ($q) use ($user){
            $q->where('user_id', Auth::user()->id);
            $q->where('user_to_id', $user->id);
        })->orWhere(function ($q) use ($user){
            $q->where('user_id', $user->id);
            $q->where('user_to_id', Auth::user()->id);
        })->get();

        //Mark the messages as read by adding a timestamp to them
        $messages = $messages->map(function($message) {
            if($message->read_at == null){
                Message::find($message->id)->update(['read_at' => Carbon::now()]);
            }
            return $message;
        });


        return response()->json($messages);
    }
    /**
     * this method is called when we send a message to a user who is watching the chat  window. In that case the message has to be read immediately
     */
   public function update($id){
        $message = Message::find($id);
        $message->update(['read_at' => Carbon::now()]);
        return response()->json($message);
   }
   
   /**
    * This method saves the new message to the db and send to the pusher module
    */
    public function store(Request $request){
        $message = Message::create([
            'user_id' => Auth::user()->id,
            'user_to_id' => $request->contact,
            'body' => $request->text
        ]);
        broadcast(new NewMessage($message));
        if(!$message){
            return response("error", 500);
        }   
        return response()->json($message);
    }
    
}
