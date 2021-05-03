<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Friend extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'friend_id', 'accepted_at'];

    public function user(){
        return $this->belongsTo(User::class, 'friend_id');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
