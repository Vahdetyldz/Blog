<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // Tüm blog yazılarını listeleme
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->take(4)->get(); // Sadece ilk 4 blog
        return view('BlogPage', compact('blogs'));
    }
    public function myindex(){
        $blogs = Blog::all()->where('user_id',session('user'));
        return view('myBlogs', compact('blogs'));
    }
    public function GetAll() {

        $AllBlog=Blog::all();
        return response()->json( $AllBlog );
    }
    public function GetById(Request $request, $id) {
        $blog = Blog::with('user:id,name,surname')
            ->find($id);
        return view('content', compact('blog'));
    }
    // BlogController.php
    public function loadMoreBlogs(Request $request)
    {
        $offset = $request->input('offset');
        $limit = 4;

        // Verileri ters sırada çek
        $blogs = Blog::with('user:id,name,surname')
                    ->orderBy('id', 'desc')
                    ->skip($offset)
                    ->take($limit)
                    ->get();

        return response()->json($blogs);
    }

    // Yeni blog yazısı oluşturma
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subTitle' => 'required',
            'content' => 'required'
        ]);
        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'subTitle' => $request->subTitle,
            'user_id' => session('user')
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
        if (!$blog || $blog->user_id != session('user')) {
            return response()->json(['message' => 'Yetkisiz işlem'], 403);
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'subTitle' => 'required'
        ]);

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'subTitle' => $request->subTitle
        ]);

        return redirect('/')->with('success', 'Blog başarıyla güncellendi!');
    }

    // Blog yazısını silme
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog || $blog->user_id != session('user')) {
            return response()->json(['message' => 'Yetkisiz işlem'], 403);
        }

        $blog->delete();
        return redirect('/')->with('success', 'Blog başarıyla silindi!');
    }
}