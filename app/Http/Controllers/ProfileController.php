<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;

class ProfileController extends Controller
{
    /**
     * Method to render the Profile page content with the unread Messages and the specified user Object
     */
    public function index(User $user){
        $pictureId = $id ?? -1;
        $profileWithAllData = User::where('id', $user->id)->with('picture')->first();
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
        return view('profile.index', compact('profileWithAllData', 'userWithAllData', 'pictureId'));
    }
    public function showPicture(User $user, $id)
    {
        $pictureId = $id ?? -1;
        $profileWithAllData = User::where('id', $user->id)->with('picture')->first();
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
        return view('profile.index', compact('profileWithAllData', 'userWithAllData', 'pictureId'));
    }
    

}
