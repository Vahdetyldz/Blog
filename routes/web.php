<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// Ana sayfa
Route::get('/', [BlogController::class, 'index'])->name('home');

// Giriş & Kayıt Sayfaları
Route::view('/login', 'login')->name('login.form');
Route::view('/register', 'register')->name('register.form');

// Blog İşlemleri (Sadece giriş yapmış kullanıcılar için)
Route::middleware('auth')->group(function () {
    Route::view('/create-blog', 'createBlog')->name('blog.create');
    
    Route::get('/blog-my-blogs', [BlogController::class, 'myIndex'])->name('blog.myblogs');

    Route::post('/blogs', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/blogs/{blog}/update', [BlogController::class, 'update'])->name('blog.update'); 
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy'); 
});

// Giriş ve Çıkış İşlemleri
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Blog detayları ve yükleme işlemleri
Route::get('/blog-content/{blog}', [BlogController::class, 'getById'])->name('blog.show'); 
Route::get('/blogs/load-more-blogs', [BlogController::class, 'loadMoreBlogs'])->name('blogs.load-more');
