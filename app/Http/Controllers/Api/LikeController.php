<?php

namespace App\Http\Controllers\Api;

use App\Models\Like;
use App\Models\Post;
use App\Mail\PostLiked;
use App\Models\Comment;
use App\Models\Picture;
use App\Mail\CommentLiked;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PostLikedNotification;

class LikeController extends Controller
{
    public function storePostLike(Request $request){
       
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
    public function storeCommentLike(Request $request)
    {
        // dd($request);
        $comment = Comment::find($request->comment_id);

        $like = Like::create([
            'user_liked_id' => Auth::user()->id,
            'likeable_id' => $comment->id,
            'likeable_type' => 'App\Models\Comment',
            'type' => "like"
            ]);
        //check if the commentable is already a post model
        $post = $comment->commentable->commentable_type ? 
        $comment->commentable->commentable : $comment->commentable;
        
        if (Auth::user() != $comment->user) {
            Mail::to($comment->user->email)->send(new CommentLiked($post, Auth::user()));
            $comment->user->notify(new PostLikedNotification($post, Auth::user()));
        }
            
        return response()->json($like);
    }
    public function storePictureLike(Request $request)
    {
        $picture = Picture::find($request->id);

        $like = Like::create([
            'user_liked_id' => Auth::user()->id,
            'likeable_id' => $picture->id,
            'likeable_type' => 'App\Models\Picture',
            'type' => "like"
        ]);

        if (Auth::user() != $picture->user) {
           // Mail::to($picture->user->email)->send(new PostLiked($picture, Auth::user()));
            //$picture->user->notify(new PostLikedNotification($picture, Auth::user()));
        }

        return response()->json($like);
    }

    public function destroy($id){
        Like::where('id', $id)->delete();
        
        return response('like has been deleted');
    }
}
