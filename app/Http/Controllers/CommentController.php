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
        
        return $comment;
    }
}
