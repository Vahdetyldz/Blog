<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');

        return response()->json([
            'message' => 'Yazı başarıyla oluşturuldu!',
            'data' => [
                'title' => $request->title,
                'category' => $request->category,
                'image_path' => $imagePath,
                'content' => $request->content,
            ],
        ], 201);
    }
}