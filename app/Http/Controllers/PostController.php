<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        // $posts = Post::with(['user', 'likes', 'postComments'])->get()->reverse();
        $unreadMessages = Auth::user() ? Message::select()->where('user_to_id', auth()->id())->where('read_at', null)->count() : 0;
        // Auth::user()->friends()->attach(1);

        // dd(Auth::user()->friends()->find(1)->with('user')->get());
        return view('posts.index', compact('unreadMessages'));
    }

    // /**
    //  * This function is for the email and the notification to show only the post has been commented or liked.
    //  */
    public function show(Post $post){
        $unreadMessages = Message::select()->where('user_to_id', auth()->id())->where('read_at', null)->count();
        $post = Post::where('id', $post->id)->with(['user', 'likes', 'postComments'])->get();
        $laravelCollection = ['user' => Auth::user(), 'post' => $post];
        return view('posts.show', compact('unreadMessages', 'laravelCollection'));
    }

    // /**
    //  * Save the post to the database
    //  * the text is mandatory the picture not -> in that case it has a null value
    //  */
    // public function store(Request $request){
    //     $this->validate($request, [
    //         'body' => 'required|',
    //         'image' => 'image',
    //         'user_to' => '',

    //     ]);
    //     if($request->image){
    //         $imageName = "post_images/" . time() . '.' . $request->image->extension();
    //         $request->image->storeAs('public/', $imageName);

    //     }
    //     $post = Auth::user()->posts()->create([
    //         'body' => nl2br(e($request->body)),
    //         // 'image_path' => $imageName ?? null,
    //         'user_to_id' => $request->user_to ?? null
    //         ]);
            
    //     Picture::create([
    //         'pictureable_id' => $post->id,
    //         'pictureable_type' => 'App\Models\Post',
    //         'url' => $imageName
    //     ]);
        
    //     return back();
    // }
    // /**
    //  * Deleting the post
    //  */
    // public function destroy(Post $post){
    //     if(Auth::user() != $post->user){
    //         return response('', 409);
    //     }
    //     $post->delete();
    //     return back();
    // }

    
}
