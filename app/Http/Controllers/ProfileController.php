<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class ProfileController extends Controller
{
    public function index(User $user){
        $unreadMessages = Message::select()->where('user_to_id', Auth::user()->id)->where('read_at', null)->count();
        return view('profile.index', [
            'user' => $user,
            'unreadMessages' => $unreadMessages
        ]);
    }
}
