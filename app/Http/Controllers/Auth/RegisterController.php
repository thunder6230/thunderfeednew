<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use BeyondCode\EmailConfirmation\Traits\RegistersUsers;

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
        $userWithAllData = 0;
        return view('auth.register', compact('userWithAllData'));
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
            'name' => 'required|min:4|max:120|regex:/^[a-zA-Z ]+$/',
            'username' => 'required|min:5|max:120',
            'email' => 'required|max:255|email',
            'gender' => 'required',
            // 'password'=> 'required|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'password' => 'required|confirmed|min:8',
            'path' => 'required|string'
        ]);
        
        if(User::where('email', $request->email)->first()){
                return response()->json(['success' => false, 'message' => 'This email is already in use!']);

        };
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
            'url' => $this->profilePicture($request->gender),
            'user_id' => $user->id
        ]);

        // event(new Registered($user));
        Auth::attempt($request->only(['email', 'password']));
        Auth::user()->createToken('user-access');
    
        
        // return response()->json(Auth::user());
        return response()->json(['success' => true, 'path' => $request->path]);
    }
   
}
