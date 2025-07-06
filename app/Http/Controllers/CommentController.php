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
    
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'root' || Auth::id() === $comment->user_id) {
            $comment->delete();
            return response()->json(['success' => true, 'message' => 'Yorum başarıyla silindi!']);
        }
        return response()->json(['success' => false, 'message' => 'Bu yorumu silme yetkiniz yok!'], 403);
    }
    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'root' || Auth::id() === $comment->user_id) {
            $comment->update([
                'comment' => $request->comment
            ]);
            return redirect()->back()->with('success', 'Yorum başarıyla güncellendi!');
        }
        return redirect()->back()->with('error', 'Bu yorumu güncelleme yetkiniz yok!');
    }
    public function getAll()
    {
        $comments = Comment::with(['user', 'blog'])->orderBy('id', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $comments
        ]);
    }
}
