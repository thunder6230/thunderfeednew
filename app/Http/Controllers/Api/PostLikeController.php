<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Mail\PostLiked;
use App\Models\PostLike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PostLikedNotification;

class PostLikeController extends Controller
{
    public function store(Request $request){
       
        $post = Post::find($request->post_id);
        $like = $post->likes()->create(['user_id' => Auth::user()->id]);
        if(!$like){
            echo "Error";
        }
        if(Auth::user() != $post->user){
            Mail::to($post->user->email)->send(new PostLiked($post, Auth::user()));
            $post->user->notify(new PostLikedNotification($post, Auth::user()));
        }
        return response()->json(PostLike::find($like->id));
    // return response(true);
    }
    public function destroy($id){

        if(!Post::find($id)->likes()->where('user_id', Auth::user()->id)->delete()){
            echo "Error";
        }
        return response()->json(['like_id' => $id, 'isLikedByMe' => false]);
    }
}
