<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'profile_picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return $this->email_address;
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function comments(){
        return $this->hasMany(PostComment::class);
    }

    // public function isMyFriend(){
    //     return $this->belongsToMany(User::class, 'user_friend', 'user_id', 'friend_id');
    // }
    public function friends(){
        return $this->hasMany(Friend::class);
    }

    public function isMyFriend(User $user){
        return $this->friends->where('friend_id', $user->id);
    }
    
   
    public function isMyAcceptedFriend(User $user){
        return $this->isMyfriend($user)->where('accepted_at', !null);
    }

    public function isMyAcceptedFriendById($id)
    {
        $user = User::find($id);
        return $this->friends->where('friend_id', $user->id)->where('accepted_at', !null);
        
    }
    
    public function messages(){
        return $this->hasMany(Message::class);
    }

    
    
}
