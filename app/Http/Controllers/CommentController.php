<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index($id)
    {
        $comments = Comment::where('blog_id', $id);
        return view('',compact($comments));
    }
    
}
