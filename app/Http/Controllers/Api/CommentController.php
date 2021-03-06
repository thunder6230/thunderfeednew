<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Picture;
use App\Mail\PostCommented;
use App\Models\PostComment;
use App\Mail\CommentReplied;
use Illuminate\Http\Request;
use App\Mail\PictureCommented;
use App\Mail\PictureCommentReplied;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PostCommentedNotification;
use App\Notifications\CommentRepliedNotification;
use App\Notifications\PictureCommentedNotification;
use App\Notifications\PictureCommentRepliedNotification;

class CommentController extends Controller
{
    public function storePostComment($id, Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
            'file' => 'image',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'body' => $request->body,
            'commentable_id' => $id,
            'commentable_type' => 'App\Models\Post'
        ]);
        if ($request->file) {

            $imageName = "Pictures/" . time() . '.' . $request->file->extension();
            $request->file->storeAs('public/', $imageName);

            Picture::create([
                'user_id' => Auth::user()->id,
                'pictureable_id' => $comment->id,
                'pictureable_type' => 'App\Models\Comment',
                'url' => $imageName
            ]);
        }
        if (Auth::user()->id != $comment->commentable->user->id) {
            Mail::to($comment->user->email)->send(new PostCommented($comment->commentable, Auth::user()));
            $comment->commentable->user->notify(new PostCommentedNotification($comment->commentable, User::with('pictures')->find(Auth::user()->id)));
        }
        $comment = Comment::where('id', $comment->id)->with(
            'pictures',
            'user',
            'user.pictures',
            'likes',
            'replies',
            'replies.likes',
            'replies.user',
            'replies.user.pictures',
        )->get();
        return response()->json($comment);
    }

    public function storePictureComment($id, Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
            'file' => 'image',
        ]);
        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'body' => $request->body,
            'commentable_id' => $id,
            'commentable_type' => 'App\Models\Picture'
        ]);
        if ($request->file) {

            $imageName = "Pictures/" . time() . '.' . $request->file->extension();
            $request->file->storeAs('public/', $imageName);

            Picture::create([
                'user_id' => Auth::user()->id,
                'pictureable_id' => $comment->id,
                'pictureable_type' => 'App\Models\Post',
                'url' => $imageName
            ]);
        }
        if (Auth::user()->id != $comment->commentable->user->id) {
            Mail::to($comment->user->email)->send(new PictureCommented($comment->commentable, Auth::user()));
            $comment->commentable->user->notify(new PictureCommentedNotification($comment->commentable, User::with('pictures')->find(Auth::user()->id)));
        }
        $comment = Comment::where('id', $comment->id)->with(
            'pictures',
            'user',
            'likes',
            'user.pictures',
            'replies',
            'replies.likes',
            'replies.user',
            'replies.user.pictures',
        )->get();
        return response()->json($comment);
    }
    public function storeCommentReply($id, Request $request){
        $this->validate($request, [
            'body' => 'required',
            'file' => 'image',
        ]);
        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'body' => $request->body,
            'commentable_id' => $id,
            'commentable_type' => 'App\Models\Comment'
        ]);
        if ($request->file) {

            $imageName = "Pictures/" . time() . '.' . $request->file->extension();
            $request->file->storeAs('public/', $imageName);

            Picture::create([
                'user_id' => Auth::user()->id,
                'pictureable_id' => $comment->id,
                'pictureable_type' => 'App\Models\Comment',
                'url' => $imageName
            ]);
        }
        // dd($comment->commentable->commentable_type == "App\Models\Picture");
        //Post Comment
        if($comment->commentable->commentable_type == "App\Models\Comment"){
            if(Auth::user()->id != $comment->commentable->user->id) {
                Mail::to($comment->user->email)->send(new CommentReplied($comment->commentable->commentable, Auth::user()));
                $comment->commentable->user->notify(new CommentRepliedNotification($comment->commentable->commentable, User::with('pictures')->find(Auth::user()->id)));
            }
            if ($comment->commentable->commentable->user_to_id) {
                $user_to = User::find($$comment->commentable->commentable->user_to_id);
                Mail::to($user_to->email)->send(new CommentReplied($comment->commentable->commentable, Auth::user()));
                $user_to->notify(new CommentRepliedNotification($comment->commentable->commentable, User::with('pictures')->find(Auth::user()->id)));
            }
        };
        //Picture Comment
        if ($comment->commentable->commentable_type == "App\Models\Picture") {
            if (Auth::user()->id != $comment->commentable->user->id) {
                Mail::to($comment->user->email)->send(new PictureCommentReplied($comment->commentable->commentable, Auth::user()));
                $comment->commentable->user->notify(new PictureCommentRepliedNotification($comment->commentable->commentable, User::with('pictures')->find(Auth::user()->id)));
                
            }
        };


        $comment = Comment::where('id', $comment->id)->with(
            'pictures',
            'likes',
            'user',
            'user.pictures',
            'replies',
            'replies.likes',
            'replies.user',
            'replies.user.pictures',
        )->first();
        return response()->json($comment);
    }

    public function destroy($id){
        if(Comment::where('id', $id)->delete()){
            return response($id);
        }
    }

    public function update(Request $request)
    {
        $comment_id = $request->comment_id;
        $new_body = $request->new_body;


        $comment = Comment::find($comment_id);
        if (!$comment->update(['body' => $new_body])) {
            return response()->json(['succes' => false]);
        }
        return response()->json(['succes' => true]);
    }
  
}
