<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct(){
        $this->middleware(['guest']);

    }
    public function index(){
        return view('auth.register');
    }

    public function profilePicture($gender){
        return strtolower($gender) == "male" ? "profile_pictures/male_default.jpg" : "profile_pictures/female_default.jpg";
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255|regex:/^[a-zA-Z ]+$/',
            'username' => 'required|max:255',
            'email' => 'required|max:255|email',
            'gender' => 'required',
            // 'password'=> 'required|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'password' => 'required|min:8',
        ]);
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'profile_picture' => $this->profilePicture($request->gender)
        ]);
        
        Auth::attempt($request->only(['email', 'password']));
        Auth::user()->createToken('user-access');
        
        return redirect('posts');
    }
   
}
