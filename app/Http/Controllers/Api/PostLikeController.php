<?php

namespace App\Http\Controllers\Api;

use App\Models\Like;
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

        $like = Like::create([
            'user_liked_id' => Auth::user()->id,
            'likeable_id' => $post->id,
            'likeable_type' => 'App\Models\Post',
            'type' => "like"
        ]);
        
        if(Auth::user() != $post->user){
            Mail::to($post->user->email)->send(new PostLiked($post, Auth::user()));
            $post->user->notify(new PostLikedNotification($post, Auth::user()));
        }
        
        return response()->json($like);
    }
    public function destroy($id){
        
        Like::where("likeable_type", "App\Models\Post")
                ->where('likeable_id', $id)
                ->where('user_liked_id', Auth::user()->id)
                ->delete();
        
        return response('like has been deleted');
    }
}
