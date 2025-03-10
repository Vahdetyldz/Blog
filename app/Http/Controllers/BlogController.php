<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    // Tüm blog yazılarını listeleme
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->paginate(4);
        return view('blog-page', compact('blogs'));
    }
    public function myIndex(){
        $blogs = Blog::where('user_id',Auth::id())->get();
        return view('myBlogs', compact('blogs'));
    }
    public function getAll() {

        $AllBlog=Blog::all();
        return response()->json( $AllBlog );
    }
    public function getById(Request $request, $id) {
        $blog = Blog::with('user:id,name,surname')->where('id', $id)->first();
        return view('content', compact('blog'));
    }

    // Yeni blog yazısı oluşturma
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'content' => 'required'
        ]);
        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'subtitle' => $request->subtitle,
            'user_id' => Auth::id()
        ]);
        return redirect('/')->with('success', 'Blog başarıyla Kaydedildi!');
    }
    // Blog yazısını güncelleme
    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if (!$blog || $blog->user_id != Auth::id()) {
            return response()->json(['message' => 'Yetkisiz işlem'], 403);
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'subtitle' => 'required'
        ]);

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'subtitle' => $request->subtitle
        ]);

        return redirect('/')->with('success', 'Blog başarıyla güncellendi!');
    }

    // Blog yazısını silme
    public function destroy(Request $request, $id)
    {
        if($request->user()->id != Auth::id()) {
            return response()->json(['message' => 'Yetkisiz işlem'], 403);
        }
        $blog = Blog::find($id);
        if (!$blog || $blog->user_id != Auth::id()) {
            return response()->json(['message' => 'Yetkisiz işlem'], 403);
        }

        $blog->delete();
        return redirect('/')->with('success', 'Blog başarıyla silindi!');
    }
}