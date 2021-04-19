<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Message;
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
     * We get all the posts from the database with eager loading to make more efficient the query. We check the onread messages count as well and pass both values to the view element.
     */
    public function index(){
        $posts = Post::with(['user', 'likes', 'postComments'])->get()->reverse();
        $unreadMessages = Message::select()->where('user_to_id', auth()->id())->where('read_at', null)->count();
        return view('posts.index', [
            'posts' => $posts,
            'unreadMessages' => $unreadMessages
        ]);
    }

    /**
     * This function is for the email and the notification to show only the post has been commented or liked.
     */
    public function show(Post $post){
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Save the post to the database
     * the text is mandatory the picture not -> in that case it has a null value
     */
    public function store(Request $request){
        $this->validate($request, [
            'body' => 'required|',
            'image' => 'image',
            'user_to' => '',

        ]);
          
            
        if($request->image){
            $imageName = "post_images/" . time() . '.' . $request->image->extension();
            $request->image->storeAs('public/', $imageName);

        }

        Auth::user()->posts()->create([
            'body' => $request->body,
            'image_path' => $imageName ?? null,
            'user_to_id' => $request->user_to ?? null
        ]);

        return back();
    }
    /**
     * Deleting the post
     */
    public function destroy(Post $post){
        if(Auth::user() != $post->user){
            response('', 409);
        }
        $post->delete();
        return back();
    }

    
}
