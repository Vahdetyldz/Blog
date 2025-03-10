<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
// Ana sayfa
Route::get('/', [BlogController::class, 'index'])->name('home');

// Giriş & Kayıt Sayfaları
Route::get('/login', function () {
    return view('login');
})->name('login.form');

Route::get('/register', function () {
    return view('register');
})->name('register.form');


// Blog İşlemleri (Sadece giriş yapmış kullanıcılar için)
Route::middleware('auth')->group(function () {
    Route::get('/createBlog', function () {
        return view('createBlog');
    })->name('createblog');

    Route::get('/blog-myBlogs', [BlogController::class, 'myIndex'])->name('myblogs');

    Route::post('/blogs-store', [BlogController::class, 'store'])->name('post.store');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('post.edit');
    Route::post('/blogs/{blog}/update', [BlogController::class, 'update'])->name('post.update'); 
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('post.destroy'); 
});

// Giriş ve Çıkış İşlemleri
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Blog detayları ve yükleme işlemleri
Route::get('/blog-content/{blog}', [BlogController::class, 'getById'])->name('post.show'); 
Route::get('/blogs/load-more-blogs', [BlogController::class, 'loadMoreBlogs'])->name('blogs.load-more');
