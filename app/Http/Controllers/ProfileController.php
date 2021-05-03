<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Friend;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class ProfileController extends Controller
{
    /**
     * Method to render the Profile page content with the unread Messages and the specified user Object
     */
    public function index(User $user){
        $unreadMessages = Message::select()->where('user_to_id', Auth::user()->id)->where('read_at', null)->count();
        // $user = User::where('id', $user->id);
        $users = ['userProfile' => $user, 'userLoggedIn' => Auth::user()];
        return view('profile.index', compact('unreadMessages', 'users'));
    }

}
