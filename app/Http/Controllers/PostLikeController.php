<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\PostLiked;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PostLikedNotification;
use Illuminate\Support\Facades\Notification;

class PostLikeController extends Controller
{
    public function store(Post $post){

        if($post->userLiked(Auth::user())){
            return response(null, 409);
        }
        
        $post->likes()->create([
            'user_id' => Auth::user()->id
        ]);

        Mail::to($post->user->email)->send(new PostLiked($post, Auth::user()));

  
        $post->user->notify(new PostLikedNotification($post, Auth::user()));
        return back();
    }

    public function destroy(Post $post){
        if($post->userLiked(Auth::user())){
            PostLike::where('user_id', Auth::user()->id)->delete();
        }
        return back();
    }
}
