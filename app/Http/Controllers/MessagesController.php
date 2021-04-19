<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index(){
        $unreadMessages = Message::select()->where('user_to_id', Auth::user()->id)->where('read_at', null)->count();
        return view('messages.index', ['unreadMessages' => $unreadMessages]);
    }
}
