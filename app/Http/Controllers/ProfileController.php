<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class ProfileController extends Controller
{
    public function index(User $user){

       
        // dd(Auth::user()->isMyAcceptedFriend($user));
        return view('profile.index', [
            'user' => $user
        ]);
    }
}
