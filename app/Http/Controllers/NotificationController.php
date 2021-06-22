<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Only for logged in user
     */
    public function __construct(){
        $this->middleware(['auth']);
    }
    /**
     * rendering the nptifications view element with the unreadmessages count and the user Object
     */
    public function index(user $user){
        $userWithAllData = 0;
        if (Auth::user()) {
            $userWithAllData = User::with(
                'picture',
                'unreadNotifications',
                'notifications',
                'unreadMessages',
                'friends',
                'friendOf'
            )->find(Auth::user()->id);
        }

        return view('notifications.index', compact('userWithAllData'));
    }
}
