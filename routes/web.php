<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; /*Laravel doğrulama sistemi */
use Illuminate\Http\Request;
use App\Models\Blog;

// Ana sayfa
//Route::get('/', [BlogController::class, 'index']);
Route::get('/', [BlogController::class, 'index']);
/*Route::get('/', function () {
    return view('content');
});*/

// Giriş & Kayıt Sayfaları
Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});
Route::get('/createBlog', function () {
    return view('createBlog');
})->name('createblog');

Route::get('/blog-myBlogs/{id}',[BlogController::class, 'myindex'])->name('myblogs');


// Kullanıcı İşlemleri
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
//Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Blog İşlemleri
Route::middleware('web')->group(function () {
    Route::get('/blogs/load-more-blogs', [BlogController::class, 'loadMoreBlogs']);
    Route::get('/blog-content/{id}', [BlogController::class, 'GetById']);
    
    //Route::get('/blogs', [BlogController::class, 'index'])->name('home');
    Route::post('/blogs-store', [BlogController::class, 'store'])->name('post.store');
    Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('post.edit');
    Route::post('/blogs/{id}/update', [BlogController::class, 'update'])->name('post.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('post.destroy');
});
