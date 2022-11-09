<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index'])
    ->middleware('auth')
    ->name('home');

Route::post('/logout', [BlogController::class, 'logout'])->name('logout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blogs.index');
    Route::match(['get', 'post'], '/create', [BlogController::class, 'create'])->name('blog.create');
    Route::get('/all', [BlogController::class, 'allBlogs'])->name('allBlogs');
    Route::get('/{id}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/{id}/show', [BlogController::class, 'allBlogsShow'])->name('allblog.show');
    Route::match(['get', 'post'], '{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::get('{id}/delete', [BlogController::class, 'destroy'])->name('blog.delete');
});

Route::prefix('/profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::match(['get', 'post'], 'image', [ProfileController::class, 'profileImage'])->name('profile.image');

});

Route::match(['get', 'post'], 'blogs/{id}/comment', [CommentController::class, 'comment'])->name('comment');

Route::get('/comments', [AdminController::class, 'comment'])->name('comment.all');
Route::get('users', [AdminController::class, 'users'])->name('users.all');
Route::match(['get', 'post'], 'users/{id}/edit', [AdminController::class, 'editUsers'])->name('users.edit');
Route::get('users/{id}', [AdminController::class, 'usersShow'])->name('users.show');
Route::get('admin/blogs', [AdminController::class, 'blog'])->name('admin.blog');
Route::get('{id}/delete', [AdminController::class, 'destroy'])->name('user.delete');
Route::get('/comment/{id}/delete', [AdminController::class, 'commentDestroy'])->name('comment.delete');

Route::prefix('friends')->group(function () {
    Route::get('/', [FriendsController::class, 'index'])->name('friends.index');
    Route::get('{id}/add', [FriendsController::class,'add'])->name('friend.add');
    Route::post('{id}/accept', [FriendsController::class,'accept'])->name('friend.accept');
});
