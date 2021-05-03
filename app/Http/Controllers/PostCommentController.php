<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\PostCommented;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PostCommentedNotification;

class PostCommentController extends Controller
{
    /**
     * Save the comment to the database. Like the at the post the body is required and the picture is optional. After comment we send an email and a notification to the owner.
     */
    // public function store(Request $request, Post $post){

    //     $this->validate($request, [
    //         'comment_body' => 'required',
    //         'comment_image' => 'image'
            
    //     ]);

    //     if ($request->comment_image) {
    //         $imageName = "comment_images/" . time() . '.' . $request->comment_image->extension();
    //         $request->comment_image->storeAs('public/', $imageName);
    //     }
    //     Auth::user()->comments()->create([
    //         'post_id' => $post->id,
    //         'body' => $request->comment_body,
    //         'comment_picture' => $imageName ?? null
    //     ]);

    //     Mail::to($post->user->email)->send(new PostCommented($post, Auth::user()));
    //     $post->user->notify(new PostCommentedNotification($post, Auth::user()));
    //     return back();
    // }
    // public function destroy(PostComment $postComment){
    //     if($postComment->user != Auth::user()){
    //         response('', 409);
    //     }
    //     $postComment->delete();
    //     return back();
    // }
}
