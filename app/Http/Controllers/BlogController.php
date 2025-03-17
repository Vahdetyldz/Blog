<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->paginate(4);

        return view('blog-page', compact('blogs'));
    }
    public function myIndex()
    {
        $blogs = Blog::where('user_id',Auth::id())->get();

        return view('myBlogs', compact('blogs'));
    }
    public function getAll() 
    {
        $AllBlog=Blog::all();

        return response()->json( $AllBlog );
    }
    public function getById($id) 
    {
        $blog = Blog::with('user:id,name,surname')->where('id', $id)->first();
        $comments = Comment::where('blog_id', $id)->get();

        return view('content', compact('blog','comments'));
    }

    public function store(BlogRequest $request)
    {
        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'subtitle' => $request->subtitle,
            'user_id' => Auth::id()
        ]);

        return redirect('/')->with('success', 'Blog başarıyla Kaydedildi!');
    }

    public function edit($id)
    {
        $blog = Blog::find($id);

        return view('edit', compact('blog'));
    }

    public function update(BlogRequest $request, $id)
    {
        $blog = Blog::find($id);
        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'subtitle' => $request->subtitle
        ]);

        return redirect('/')->with('success', 'Blog başarıyla güncellendi!');
    }

    public function destroy($id)
    {
        $blog = Blog::find($id); 
        if($blog->user_id != Auth::id())
        {
            return redirect('/')->with('error', 'Bu blogu silemezsiniz!');
        }
        $blog->delete();

        return redirect('/')->with('success', 'Blog başarıyla silindi!');
    }
}