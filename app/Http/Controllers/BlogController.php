<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;

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
    public function getAll(Request $request)
    {
        $blogs = Blog::with(['user:id,name,surname', 'category:id,name'])->orderBy('id', 'desc')->paginate(4);
        return response()->json($blogs);
    }


    public function getById($id) 
    {
        $blog = Blog::with('user:id,name,surname')->where('id', $id)->first();
        $comments = Comment::where('blog_id', $id)->get();

        return view('content', compact('blog','comments'));
    }

    public function store(BlogRequest $request)
    {
        //Log::info('Gelen Başlık:', $request->title);
        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'subtitle' => $request->subtitle,
            'image' => $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Başarıyla Kaydedildi!'
        ]);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->image_url = $blog->image ? asset('storage/' . $blog->image) : null;
        return response()->json($blog);
    }
    public function update(BlogRequest $request, $id)
    {
        $blog = Blog::find($id);
        $blog->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'subtitle' => $request->subtitle
        ]);

        if ($request->hasFile('image')) {
            // Yeni resim yükle ve kaydet
            $path = $request->file('image')->store('images', 'public');
            $blog->image = $path;
        }
        // Eğer resim yoksa eski resim korunur

        $blog->save();

        return response()->json($blog);
    }

    public function destroy($id)
    {
        $blog = Blog::find($id); 
        if($blog->user_id != Auth::id())
        {
            return redirect('/')->with('error', 'Bu blogu silemezsiniz!');
        }
        $blog->delete();

        return response()->json(['message' => 'Silindi'], 200);
    }

    public function mockStore()
    {
        // Gerçek kayıt işlemi yok, sadece hızlıca yanıt dönülüyor
        return response()->json([
            'success' => true,
            'message' => 'Mock: Blog kaydı simüle edildi!'
        ]);
    }
}