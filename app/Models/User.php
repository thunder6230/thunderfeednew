<?php

namespace App\Models;

use App\Models\Post;

use App\Models\Message;
use App\Models\Picture;
use App\Models\PostComment;
use Illuminate\Auth\MustVerifyEmail as AuthMustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, CanResetPassword;

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
        'gender',
        'confirmed_at',
        'confirmation_code'
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
        return $this->hasMany(Message::class, 'user_to_id')->whereNull('read_at');
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
