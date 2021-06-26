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
        $userWithAllData = 0;
        if (Auth::user()) {
            $userWithAllData = User::with(
                'pictures',
                'unreadNotifications',
                'notifications',
                'unreadMessages',
                'friends',
                'friendOf'
            )->find(Auth::user()->id);
        }
        $isMessages = true;
        return view('messages.index', compact('userWithAllData', 'isMessages'));
    }
}
