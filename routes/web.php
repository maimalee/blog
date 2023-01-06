<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NotificationController;
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

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/blogs')->middleware('auth')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blogs.index');
    Route::post('getFriends', [BlogController::class, 'getfriendsName'])->name('friends.name');
    Route::match(['get', 'post'], '/create', [BlogController::class, 'create'])->name('blog.create');
    Route::match(['get','post'],'/all', [BlogController::class, 'allBlogs'])->name('allBlogs');
    Route::match(['get', 'post'], '/{id}', [BlogController::class, 'show'])->name('blog.show');
    Route::match(['get', 'post'], '/{id}/show', [BlogController::class, 'allBlogsShow'])->name('allblog.show');
    Route::match(['get', 'post'], '{id}/edit', [BlogController::class, 'editApi'])->name('blog.edit');
    Route::get('{id}/delete', [BlogController::class, 'destroy'])->name('blog.delete');
});

Route::prefix('/profile')->middleware('auth')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::match(['get', 'post'], 'image', [ProfileController::class, 'profileImage'])->name('profile.image');

});

Route::match(['get', 'post'], 'blogs/{id}/comment', [CommentController::class, 'comment'])->name('comment')->middleware('auth');

Route::get('/comments', [AdminController::class, 'comment'])->name('comment.all')->middleware('auth');

Route::get('users', [AdminController::class, 'users'])->name('users.all')->middleware('auth');
Route::match(['get', 'post'], 'user/add', [AdminController::class, 'add'])->name('user.add')->middleware('auth');
Route::get('{id}/recover', [AdminController::class, 'recover'])->name('user.recover')->middleware('auth');
Route::match(['get', 'post'], 'users/{id}/edit', [AdminController::class, 'editUsers'])->name('users.edit')->middleware('auth');
Route::get('users/{id}', [AdminController::class, 'usersShow'])->name('users.show')->middleware('auth');
Route::get('admin/blogs', [AdminController::class, 'blog'])->name('admin.blog')->middleware('auth');
Route::get('{id}/delete', [AdminController::class, 'destroy'])->name('user.delete')->middleware('auth');
Route::get('/comment/{id}/delete', [AdminController::class, 'commentDestroy'])->name('comment.delete')->middleware('auth');
Route::match(['get','post'], '/comment/{id}/edit', [AdminController::class, 'commentEdit'])->name('comment.edit');
Route::match(['get','post'], '{id}/edit', [AdminController::class, 'editBlog'])->name('admin.editBlog')->middleware('auth');

Route::prefix('friends')->middleware('auth')->group(function () {
    Route::get('/', [FriendsController::class, 'index'])->name('friends.index');
    Route::get('{id}/show', [FriendsController::class,'profile'])->name('friend.profile');
    Route::get('{id}/add', [FriendsController::class, 'add'])->name('friend.add');
//    Route::post('{id}/accept', [FriendsController::class, 'accept'])->name('friend.accept');
//    Route::post('{id}/reject', [FriendsController::class, 'reject'])->name('friend.reject');

});

Route::prefix('notifications')
    ->name('notifications.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/{id}', [NotificationController::class, 'read'])->name('read');
    });
