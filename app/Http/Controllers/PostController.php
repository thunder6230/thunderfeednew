<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('index');
    }
    
    public function index(){
        $posts = Post::all()->reverse();
        return view('posts.index', [
            'posts' => $posts
        ]);
    }
    public function show(Post $post){
        return view('posts.show', ['post' => $post]);
    }
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

    public function destroy(Post $post){
        if(Auth::user() != $post->user){
            response('', 409);
        }
        $post->delete();
        return back();
    }

    
}
