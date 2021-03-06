<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = ['pictureable_id', 'pictureable_type', 'url', 'user_id'];

    public function pictureable() {
        return $this->morphTo();
    }
    public function likes(){
        return $this->morphMany(Like::class, 'likeable');
    }
    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
