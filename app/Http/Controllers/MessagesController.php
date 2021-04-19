<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    /**
     * Only for logged in users
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * We render the messages view and pass the unread messages count
     */
    public function index(){
        $unreadMessages = Message::select()->where('user_to_id', Auth::user()->id)->where('read_at', null)->count();
        return view('messages.index', ['unreadMessages' => $unreadMessages]);
    }
}
