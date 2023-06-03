<?php

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogTagController;
use App\Http\Controllers\BlogSearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Blog\BlogCategories;
use App\Http\Livewire\Blog\BlogTags;
use App\Http\Livewire\Blog\BlogPosts;
use App\Http\Livewire\Blog\PostForm;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogPostController::class, 'index'])->name('index');
    Route::get('article/{blog_post:slug}', [BlogPostController::class, 'show'])->name('page');
    Route::get('category/{blog_category:slug}', [BlogCategoryController::class, 'show'])->name('category');
    Route::get('tag/{blog_tag:slug}', [BlogTagController::class, 'show'])->name('tag');
    Route::get('search', [BlogSearchController::class, 'index'])->name('search');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::view('dashboard', 'dashboard')->middleware('verified')->name('dashboard');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('images', [ImageController::class, 'store'])->name('admin.images.store');

    Route::prefix('blog')->name('admin.blog.')->group(function () {
        Route::get('categories', BlogCategories::class)->name('categories.index');
        Route::get('tags', BlogTags::class)->name('tags.index');
        Route::get('posts', BlogPosts::class)->name('posts.index');
        Route::get('posts/create', PostForm::class)->name('posts.create');
        Route::get('posts/{post}', PostForm::class)->name('posts.edit');
    });

    Route::prefix('categories')->name('admin.categories.')->group(function () {
        Route::view('/', 'categories.index')->name('index');
    });

});

require __DIR__.'/auth.php';

Route::get('/{path}', [CategoryController::class, 'show'])
    ->where('path', '[a-zA-Z0-9/_-]+')
    ->name('category.show');
