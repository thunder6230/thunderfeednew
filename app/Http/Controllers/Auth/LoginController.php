<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Only as a guest avaiable
     */
    public function __construct(){
        $this->middleware('guest');
    }
    /**
     * Return the login view element
     */
    public function index(){
        $userWithAllData = 0;
        return view('auth.login', compact('userWithAllData'));
    }
    /**
     * Validate the login data and try to login. If not we resend a session message. If successfull we generate a token. it's important for the Post requests middleware.
     */
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
