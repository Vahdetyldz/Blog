<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MotorPriceController;
use App\Models\Blog;
use App\Models\Category;

//Route::post('/motor-prices', [MotorPriceController::class, 'storePrices']);

Route::post('/articles', [ArticleController::class, 'store']);

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::view('/motor-prices', 'motor_prices')->name('motor.prices');

Route::view('/login', 'login')->name('login.form');
Route::view('/register', 'register')->name('register.form');

Route::middleware('auth')->group(function () {
    Route::view('/create-blog', 'createBlog')->name('blog.create');
    
    Route::get('/blog-my-blogs', [BlogController::class, 'myIndex'])->name('blog.myblogs');

    Route::post('/api/articles', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/api/blogs/{id}', [BlogController::class, 'show']);
    Route::view('/blogs/{id}/edit', 'edit')->where('id', '[0-9]+');
    Route::post('//api/articles/{id}', [BlogController::class, 'update'])->name('blog.update'); 
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy'); 

    Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
});


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/blog-content/{blog}', [BlogController::class, 'getById'])->name('blog.show'); 
Route::get('/blogs/load-more-blogs', [BlogController::class, 'loadMoreBlogs'])->name('blogs.load-more');
Route::post('/ask', [ChatBotController::class, 'ask']);

Route::get('/admin-dashboard', function () {
    // Giriş yapan kullanıcı admin veya root değilse erişim engellenir
    if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'root')) {
        abort(403); // Yetkisiz erişim
    }

    return view('admin-dashboard'); // admin paneli için blade dosyası
})->middleware('auth')->name('admin.dashboard'); // sadece giriş yapanlar erişebilir

Route::get('/admin-CreatBlog', function () {
    if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'root')) {
        abort(403); // Yetkisiz erişim
    }

    return view('admin-create-blog');
})->middleware('auth')->name('admin.create-blog');

Route::get('/admin-category', function () {
    if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'root')) {
        abort(403); // Yetkisiz erişim
    }

    return view('admin-category-panel');
})->middleware('auth')->name('admin.category');

Route::get('/admin-users', function () {
    if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'root')) {
        abort(403); // Yetkisiz erişim
    }

    return view('admin-users-page');
})->middleware('auth')->name('admin.users');

Route::get('/admin-comments', function () {
    if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'root')) {
        abort(403); // Yetkisiz erişim
    }

    return view('admin-comments-page');
})->middleware('auth')->name('admin.comments');

Route::get('/all-blogs', function () {
    if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'root')) {
        abort(403); // Yetkisiz erişim
    }

    return view('admin-all-blogs');
})->middleware('auth')->name('admin.all-blogs');

Route::get('/test-view', function () {
    return view('fullpage'); // resources/views/dosya_adi.blade.php
});


Route::get('/web/blogs', [BlogController::class, 'getAll']);
Route::get('/web/users', [AuthController::class, 'index']);
Route::get('/web/comments', [CommentController::class, 'getAll']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

Route::get('/user-info', function () {
    return response()->json(Auth::user());
});

Route::get('/web/myblogs', function () {
    if (!Auth::check()) {
        return response()->json(['error' => 'Giriş yapılmamış'], 401);
    }

    $blogs = Blog::with('user:id,name,surname')
        ->where('user_id', Auth::id())
        ->orderBy('id', 'desc')
        ->paginate(4);

    return response()->json($blogs);
});

Route::get('/api/categories', [CategoryController::class, 'index']);
Route::post('/api/categories/add', [CategoryController::class, 'store']);


Route::patch('/users/{id}/toggle-active', [AuthController::class, 'toggleActive']);
Route::patch('/users/{id}/make-admin', [AuthController::class, 'makeAdmin']);

Route::get('/api/category-progress', [CategoryController::class, 'getCategoryProgress']);
Route::get('/api/dashboard-stats', [AuthController::class, 'dashboardStats']);
Route::get('/api/daily-stats', [AuthController::class, 'dailyStats']);
