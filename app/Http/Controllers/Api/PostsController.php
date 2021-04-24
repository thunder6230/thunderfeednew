<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostsController extends Controller
{
    public function getposts(){
        return response()->json(Post::with('user', 'likes', 'postComments', 'postComments.user')->orderBy('created_at', 'DESC')->get());
    }

    public function store(Request $request){
        $this->validate($request, [
            'body' => 'required',
            'file' => 'image|max:2048',
            'user_to' => '',
        ]);
        if ($request->file) {
            $imageName = "post_images/" . time() . '.' . $request->file->extension();
            $request->file->storeAs('public/', $imageName);
        }
        
        $post = Auth::user()->posts()->create([
            'body' => $request->body,
            'image_path' => $imageName ?? null,
            'user_to_id' => $request->user_to ?? null
        ]);
        if (!$post) {
            echo "Error";
        }
        
        return response()->json(Post::where('id',$post->id)->with('user', 'likes', 'postComments', 'postComments.user')->get());
    }

    public function show(Post $post){

    }

    public function destroy($id){
        if(!Post::findOrFail($id)->delete()){
            echo "Error";
        }
        return response()->json(['post_id' => $id]);
        
    }
}
