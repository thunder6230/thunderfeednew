<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Picture;
use App\Models\PostComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostCommentsController extends Controller
{
    public function store($id, Request $request){
        $this->validate($request, [
            'body' => 'required|',
            'image' => 'image',
        ]);
        $comment = Post::find($id)->postComments()->create([
            'user_id' => Auth::user()->id,
            'body' => $request->body,
            ]);
        if ($request->file) {
            $imageName = "post_images/" . time() . '.' . $request->file->extension();
            $request->file->storeAs('public/', $imageName);

            Picture::create([
                'pictureable_id' => $comment->id,
                'pictureable_type' => 'App\Models\PostComment',
                'url' => $imageName
            ]);
        }
        $comment = PostComment::find($comment->id);

        return response()->json($comment);
    }
    public function update(){

    }
    public function delete(){

    }
}
