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
     * We get all the posts from the database with eager loading to make more efficient the query. We check the unread messages count as well and pass both values to the view element.
     */
    public function index(){
        $userWithAllData = 0;
        if(Auth::user()){
            $userWithAllData = User::with(
                'pictures',
                'unreadNotifications',
                'notifications',
                'unreadMessages',
                'friends',
                'friendOf'
            )->find(Auth::user()->id);
        }
        return view('posts.index', compact('userWithAllData'));
    }
    
    
    /* 
     * This function is for the email and the notification to show only the post has been commented or liked.
    */
    public function show($id){

        $userWithAllData = 0;
        if (Auth::user()) {
            $userWithAllData = User::with(
                'pictures',
                'unreadNotifications',
                'notifications',
                'unreadMessages',
                'friends',
                'friendOf'
            )->find(Auth::user()->id);
        }
        $post_id = $id;
        return view('posts.show', compact('userWithAllData', 'post_id'));
    }

   

    
}
