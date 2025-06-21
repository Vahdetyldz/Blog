<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MotorPriceController;

Route::post('/motor-prices', [MotorPriceController::class, 'storePrices']);

Route::post('/articles', [ArticleController::class, 'store']);

Route::get('/', [BlogController::class, 'index'])->name('home');

Route::view('/login', 'login')->name('login.form');
Route::view('/register', 'register')->name('register.form');

Route::middleware('auth')->group(function () {
    Route::view('/create-blog', 'createBlog')->name('blog.create');
    
    Route::get('/blog-my-blogs', [BlogController::class, 'myIndex'])->name('blog.myblogs');

    Route::post('/blogs', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/blogs/{blog}/update', [BlogController::class, 'update'])->name('blog.update'); 
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy'); 

    Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/blog-content/{blog}', [BlogController::class, 'getById'])->name('blog.show'); 
Route::get('/blogs/load-more-blogs', [BlogController::class, 'loadMoreBlogs'])->name('blogs.load-more');
Route::post('/ask', [ChatBotController::class, 'ask']);

Route::get('/admin', function () {
    // Giriş yapan kullanıcı admin değilse erişim engellenir
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        abort(403); // Yetkisiz erişim
    }

    return view('admin.dashboard'); // admin paneli için blade dosyası
})->middleware('auth'); // sadece giriş yapanlar erişebilir

Route::get('/test-view', function () {
    return view('fullpage'); // resources/views/dosya_adi.blade.php
});
Route::view('/admin/dashboard', 'reactTest')->name('admin.dashboard'); // dashboard için blade dosyası

Route::get('/web/blogs', [BlogController::class, 'getAll']);

Route::get('/user-info', function () {
    return response()->json(Auth::user());
});
