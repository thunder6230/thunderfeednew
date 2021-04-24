<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{
    public function store($id, Request $request){
        $this->validate($request, [
            'body' => 'required|',
            'image' => 'image',
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
        $comment = Post::find($id)->comments()->create(['user_id']) 
        return response()->json($id);
    }
    public function update(){

    }
    public function delete(){

    }
}
