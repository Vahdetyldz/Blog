<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::select('id', 'name')
            ->withCount('blogs')
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        // blogs_count alanını ekle
        $category->blogs_count = 0;

        return response()->json($category, 201);
    }

    public function getCategoryProgress()
    {
        // Kategorileri blog sayısıyla birlikte al
        $categories = Category::withCount('blogs')->get();

        // Toplam blog sayısını hesapla
        $totalBlogs = $categories->sum('blogs_count');

        // Her kategori için yüzdeyi hesapla ve sadeleştir
        $progressData = $categories->map(function ($category) use ($totalBlogs) {
            return [
                'name' => $category->name,
                'count' => $category->blogs_count,
                'percentage' => $totalBlogs > 0
                    ? round(($category->blogs_count / $totalBlogs) * 100, 2)
                    : 0
            ];
        });

        return response()->json($progressData);
    }

}
