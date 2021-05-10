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
        $userWithAllData = User::where('id', Auth::user()->id)->with('picture', 'unreadNotifications', 'unreadMessages')->get();
        $userWithAllData = $userWithAllData[0];
        
        $profileWithAllData = User::where('id', $user->id)->with('picture')->get();
        $profileWithAllData = $profileWithAllData[0];
        if (!Auth::user()) {
            $userWithAllData = 0;
        }
        // $userCollection = ['userProfile' => $profileWithAllData, 'userLoggedIn' => User::where('id', Auth::user()->id)->with('picture')->get()];
        return view('profile.index', compact('profileWithAllData', 'userWithAllData'));
    }

}
