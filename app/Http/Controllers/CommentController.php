<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($id)
    {
        $comments = Comment::where('blog_id', $id);
        return view('',compact($comments));
    }
    public function store(CommentRequest $request)
    {
        Comment::create([
            'comment' => $request->comment,
            'user_id' => Auth::id(),
            'blog_id' => $request->blog_id
        ]);
        return redirect()->back()->with('success', 'Yorum başarıyla eklendi!');
    }
    
}
