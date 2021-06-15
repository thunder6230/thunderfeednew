<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Message;
use App\Models\Picture;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{   
    /**
     * In the costruct we can define with a middleware who has the rights to use the methods.
     * In this case a guest user can only watch the messages(method index)
     */
    public function __construct(){
        $this->middleware('auth')->except('index');
    }
    
    /**
     * We get all the posts from the database with eager loading to make more efficient the query. We check the unread messages count as well and pass both values to the view element.
     */
    public function index(){
        $userWithAllData = 0;
        if(Auth::user()){
            $userWithAllData = User::where('id', Auth::user()->id)->with(
                'picture',
                'unreadNotifications',
                'notifications',
                'unreadMessages',
                'friends',
                'friendOf'
            )->first();
        }
        return view('posts.index', compact('userWithAllData'));
    }
    
    
    /* 
     * This function is for the email and the notification to show only the post has been commented or liked.
    */
    public function show($id){
        $userWithAllData = User::where('id', Auth::user()->id)->with('picture', 'unreadNotifications', 'unreadMessages')->first();
        $post_id = $id;
        // $post = Post::where('id', $post->id)->with([
        //     'user',
        //     'user.picture',
        //     'likes', 'pictures',
        //     'comments',
        //     'comments.user',
        //     'comments.user.picture',
        //     'comments.likes',
        //     'comments.pictures',
        //     'comments.replies',
        //     'comments.replies.likes',
        //     'comments.replies.user',
        //     'comments.replies.user.picture'
        // ])->first();
        return view('posts.show', compact('userWithAllData', 'post_id'));
    }

   

    
}
