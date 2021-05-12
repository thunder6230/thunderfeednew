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
        'gender'
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
    public function picture()
    {
        return $this->morphOne(Picture::class, 'pictureable');
    }
    public function unreadMessages(){
        return $this->hasMany(Message::class)->where('read_at', null);
    }



    public function friends(){
        return $this->belongsToMany(User::class, 'friend_user', 'user_id', 'friend_id');
        // ->withPivot('accepted')
        
    }
    public function friendOf(){
        return $this->belongsToMany(User::class, 'friend_user', 'friend_id', 'user_id')->withPivot('accepted_at');
        
    }
    
    public function messages(){
        return $this->hasMany(Message::class);
    }

    
    
}
