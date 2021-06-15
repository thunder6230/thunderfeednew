<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Method to render the Profile page content with the unread Messages and the specified user Object
     */
    public function index(User $user){
        $userWithAllData = 0;
        
        $profileWithAllData = User::where('id', $user->id)->with('picture')->first();
        if (Auth::user()) {
            $userWithAllData = User::where('id', Auth::user()->id)->with(
                'picture',
                'unreadNotifications',
                'unreadMessages')->first();
        }
        return view('profile.index', compact('profileWithAllData', 'userWithAllData'));
    }

}
