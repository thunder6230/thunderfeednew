<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Only as a guest
     */
    public function __construct(){
        $this->middleware(['guest']);

    }
    /**
     * returns the register view element
     */
    public function index(){
        return view('auth.register');
    }
    /**
     * a function to decide the default profile picture
     */
    public function profilePicture($gender){
        return strtolower($gender) == "male" ? "profile_pictures/male_default.jpg" : "profile_pictures/female_default.jpg";
    }

    /**
     * the register method has validates the request elements with specific rules.
     * the validated data will be saved into the database
     * we log in the user and createing the token for the api middleware
     */
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255|regex:/^[a-zA-Z ]+$/',
            'username' => 'required|max:255',
            'email' => 'required|max:255|email',
            'gender' => 'required',
            // 'password'=> 'required|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'password' => 'required|min:8',
        ]);
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
        ]);

        Picture::create([
            'pictureable_id' => $user->id,
            'pictureable_type' => 'App\Models\User',
            'url' => $this->profilePicture($request->gender)
        ]);

        
        Auth::attempt($request->only(['email', 'password']));
        Auth::user()->createToken('user-access');
        
        return redirect('posts');
    }
   
}
