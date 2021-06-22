<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller
{
    public function index()
    {
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
        return view('users.friends', compact('userWithAllData'));
    }
}
