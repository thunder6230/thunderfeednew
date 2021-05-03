<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostsController extends Controller
{
    /**
     * Api endpoint functions for Post CRUD Requests for the Posts and User Profile Pages
     * There is a default limit of 5 in the results.
     * Of course there is a method to load more posts. there is a logic to fetch always the next 5
     */
    public function getposts(Request $request){
        $page = $request->page;
        $limit = $page * 5;
        return response()->json(Post::with('user', 'user.picture', 'user_to', 'likes', 'postComments', 'postComments.user', 'postComments.user.picture', 'picture')
                            ->orderBy('created_at', 'DESC')
                            ->limit($limit)->get());
    }

    public function getUserPosts(Request $request){
        $page = $request->page;
        $user_id = $request->user_id;
        $limit = $page * 5;

        return response()->json(Post::with('user', 'user.picture', 'user_to', 'likes', 'postComments', 'postComments.user', 'postComments.user.picture', 'picture')
                            ->where('user_id', $user_id)
                            ->orWhere('user_to_id', $user_id)
                            ->orderBy('created_at', 'DESC')
                            ->limit($limit)->get());
    }
   
    public function loadMorePosts(Request $request){
        $page = $request->page;
        $limit = $page * 5;
        $offset = $limit - 5;

        return response()->json(Post::with('user', 'user_to', 'user.picture', 'likes', 'postComments', 'postComments.user', 'postComments.user.picture', 'picture')
                            ->orderBy('created_at', 'DESC')
                            ->skip($offset)
                            ->limit($limit)->get());

    }
    public function loadMoreUserPosts(Request $request){
        $page = $request->page;
        $limit = $page * 5;
        $user_id = $request->user_id;
        $offset = $limit - 5;

        return response()->json(Post::with('user', 'user.picture', 'user_to', 'likes', 'postComments', 'postComments.user', 'postComments.user.picture', 'picture')
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->skip($offset)
            ->limit($limit)->get());

    }

    public function store(Request $request){
        $this->validate($request, [
            'body' => 'required',
            'file' => 'image|max:2048',
            'user_to_id' => '',
        ]);
        
        $post = Auth::user()->posts()->create([
            'body' => $request->body,
            'user_to_id' => $request->user_to_id ?? null
            ]);
            
        if ($request->file) {
            $imageName = "Pictures/" . time() . '.' . $request->file->extension();
            $request->file->storeAs('public/', $imageName);
            Picture::create([
                'pictureable_id' => $post->id,
                'pictureable_type' => 'App\Models\Post',
                'url' => $imageName
            ]);
        }
        if (!$post) {
            echo "Error";
        }
        
        return response()->json(Post::where('id',$post->id)
                            ->with('user', 'user.picture', 'likes', 'postComments', 'postComments.user','postComments.user.picture')->get());
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
