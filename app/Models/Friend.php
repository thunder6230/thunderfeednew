<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Friend extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'friend_id', 'accepted_at'];

    public function getFriend(){
        return $this->hasOne(User::class, 'friend_id');
    }

}
