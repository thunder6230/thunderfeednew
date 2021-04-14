<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [ 'user_id', 'body', 'user_to_id', 'image_path'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->hasMany(PostLike::class);
    }
    
    public function userLiked(User $user){
        return $this->likes->contains('user_id', $user->id);
    }

    public function postComments(){
        return $this->hasMany(PostComment::class);
    }
}
