<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Hobby;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateProfileController extends Controller
{
    public function updateData(Request $request){
        // dd($request);
        $this->validate($request, [
            'name' => 'required|min:4|max:120|regex:/^[a-zA-Z ]+$/',
            'username' => 'required|min:5|max:120',
            'email' => 'required|max:255|email',
            'relationship' => 'required'
        ]);
        User::find(Auth::user()->id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]); 
        if(count(User::find(Auth::user()->id)->relationship) == 0){
            User::find(Auth::user()->id)->relationship()->attach($request->relationship);
        }else {
            User::find(Auth::user()->id)->relationship()->update(['relationship_id' =>$request->relationship]);

        }
        return response()->json('profile data updated');
    }
    public function updateProfilePicture(Request $request){
        $this->validate($request, [
            'file' => 'required|image',
        ]);
        $imageName = "profile_pictures/" . time() . '.' . $request->file->extension();
        $request->file->storeAs('public/', $imageName);
        Picture::create([
            'user_id' => Auth::user()->id,
            'pictureable_id' => Auth::user()->id,
            'pictureable_type' => 'App\Models\User',
            'url' => $imageName,
        ]);
        return response()->json(['success' => true]);
    }
    public function updatePassword(Request $request){
        if(!Hash::check($request->oldPassword, Auth::user()->getAuthPassword())){
            return response()->json(['success' => false, 'message' => 'Invalid current password!']);
        }
        $this->validate($request, [
            'password' => 'required|confirmed|min:8'
        ]);

        User::find(Auth::user()->id)->update(['password' => Hash::make($request->password)]);
        return response()->json(['success' => true, 'message' => 'Password has benn changed!']);
        // dd(Auth::user()- === Hash::check($request->oldPassword));
        // $this->validate($request, [
        // ]);
        return response()->json('password updated');
    }
    public function getHobbies(){
        
        return response()->json(Hobby::all());
    }
    public function getUserHobbies(){
        return response()->json(Auth::user()->hobbies);
    }
    public function addHobby(Request $request){
        $hobby = Hobby::find($request->hobby_id);
        if(count(Auth::user()->hobbies->where('id', $hobby->id)) > 0){
            return response()->json(['succes' => false, 'message' => 'This hobby is already in the list!']);
        }
        Auth::user()->hobbies()->attach($hobby->id);

        return response()->json(['success' => true, 'hobby' => $hobby]);
        
        
    }
}
