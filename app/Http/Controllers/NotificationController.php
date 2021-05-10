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
            $userWithAllData = User::where('id', Auth::user()->id)->with('picture', 'unreadNotifications', 'notifications', 'unreadMessages')->get();
            $userWithAllData = $userWithAllData[0];
        }

        return view('notifications.index', compact('userWithAllData'));
    }
}
