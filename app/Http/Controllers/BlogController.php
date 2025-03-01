<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Tüm blog yazılarını listeleme
    public function index()
    {
        $blogs = Blog::all(); // Veritabanındaki tüm blogları çek
        return view('BlogPage', compact('blogs'));
    }
    // Yeni blog yazısı oluşturma
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => session('user')
        ]);

        return redirect('/blogs')->with('success', 'Blog başarıyla güncellendi!');
    }

    // Belirli bir blog yazısını gösterme
    public function show($id)
    {
        $blog = Blog::with('user')->find($id);
        if (!$blog) {
            return response()->json(['message' => 'Blog bulunamadı'], 404);
        }
        return response()->json($blog);
    }

    // Blog yazısını güncelleme
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if (!$blog || $blog->user_id != session('user')) {
            return response()->json(['message' => 'Yetkisiz işlem'], 403);
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $blog->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect('/blogs')->with('success', 'Blog başarıyla güncellendi!');
    }

    // Blog yazısını silme
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog || $blog->user_id != session('user')) {
            return response()->json(['message' => 'Yetkisiz işlem'], 403);
        }

        $blog->delete();
        return response()->json(['message' => 'Blog silindi']);
    }
}