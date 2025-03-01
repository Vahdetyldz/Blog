<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Blog;

// Ana sayfa
Route::get('/', function () {
    return view('welcome');
});

// Giriş & Kayıt Sayfaları
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/edit', function () {
    return view('edit');
});

// Kullanıcı İşlemleri
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Blog İşlemleri
Route::middleware('web')->group(function () {
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::post('/blogs-store', [BlogController::class, 'store'])->name('post.store');
    Route::get('/blogs/{id}', [BlogController::class, 'show']);
    Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('post.edit');
    Route::post('/blogs/{id}/update', [BlogController::class, 'update'])->name('post.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);
});

// AJAX ile "Older Posts" (4'erli blog yükleme)
Route::get('/load-more-blogs', function (Request $request) {
    $offset = (int) $request->offset;
    $blogs = Blog::with('user')->latest()->skip($offset)->take(4)->get();

    return response()->json([
        'blogs' => $blogs->map(function ($blog) {
            return [
                'title' => $blog->title,
                'user' => [
                    'name' => $blog->user->name,
                    'surname' => $blog->user->surname,
                ],
                'date' => \Carbon\Carbon::parse($blog->created_at)->locale('tr')->translatedFormat('j F Y')
            ];
        }),
    ]);
});
