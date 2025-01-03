<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
    {
        $comments = Comment::where('post_id', $id)->get();

        return $comments;
    }


    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'text'    => 'required|string',
            'post_id' => 'required|integer',
        ]);

        $comment = Comment::create([
            'text'    => $validated['text'],
            'post_id' => $validated['post_id'],
        ]);

        $req = \Http::post("http://localhost:8000/api/post/{$validated['post_id']}/comment", [
            'text' => $validated['text'],
        ]);

        if($req->failed())
        {
            return response()->json([
                'error'   => 'Request Failed',
                'details' => $req->body(),
            ], 500);
        }
        
        return $comment;
    }
}
