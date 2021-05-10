<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Picture;
use App\Models\PostComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function store($id, Request $request){
        $this->validate($request, [
            'body' => 'required',
            'file' => 'image',
        ]);
        $comment = Post::find($id)->postComments()->create([
            'user_id' => Auth::user()->id,
            'body' => $request->body,
        ]);
        if($request->file) {
            
        $imageName = "Pictures/" . time() . '.' . $request->file->extension();
        $request->file->storeAs('public/', $imageName);
        
        Picture::create([
            'user_id' => Auth::user()->id,
            'pictureable_id' => $comment->id,
            'pictureable_type' => 'App\Models\Comment',
            'url' => $imageName
        ]);
        }
            
        $comment = PostComment::where('id', $comment->id)->with('picture', 'user', 'user.picture')->get();
        return response()->json($comment);
    }
    public function update(){

    }
    public function destroy($id){
        if(!PostComment::findOrFail($id)->delete()){
            return response(false);
        }
        return response($id);
    }
}
