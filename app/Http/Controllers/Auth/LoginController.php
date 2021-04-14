<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }

    public function index(){
        return view('auth.login');
    }
    public function store(Request $request){
        $this->validate($request, [
            'email' => 'required|max:255|email',
            'password'=> 'required'
        ]);

        $request->password = Hash::make($request->password);
        
        if(!Auth::attempt($request->only(['email', 'password']), $request->remember)){
            return back()->with('status', 'Invalid Email or Password');
        }
        Auth::user()->createToken('user-access');
        return redirect('posts');
    }
}
