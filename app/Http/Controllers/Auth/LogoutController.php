<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * remove the token from the database and log out the user.
     */
    public function store(){
        Auth::user()->tokens()->delete();
        Auth::logout();
        return back();
    }
}
