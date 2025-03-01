<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});
Route::get('/edit', function () {
    return view('edit');
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('post.edit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('web')->group(function () {
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::post('/blogs-store', [BlogController::class, 'store'])->name('post.store');
    Route::get('/blogs/{id}', [BlogController::class, 'show']);
    Route::post('/blogs/{id}/update', [BlogController::class, 'update'])->name('post.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);
});