<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'user_to_id', 'body', 'read_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_to_id');
    }
    public function picture(){
        return $this->morphOne(Picture::class, 'pictureable');
    }
    public function like()
    {
        return $this->morphOne(Like::class, 'likeable');
    }
    
}
