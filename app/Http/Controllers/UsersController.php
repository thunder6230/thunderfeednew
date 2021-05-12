<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(){
        $userWithAllData = 0;
        if (Auth::user()) {
            $userWithAllData = User::where('id', Auth::user()->id)->with(
                'picture', 
                'unreadNotifications',
                'notifications', 
                'unreadMessages',
                'friends',
                'friendOf'
            )->first();
        }
        return view('users.users', compact('userWithAllData'));
    }
}
