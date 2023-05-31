<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::view('dashboard', 'dashboard')->middleware('verified')->name('dashboard');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('blog')->name('admin.blog.')->group(function () {
        Route::get('categories', BlogCategories::class)->name('categories.index');
        Route::get('tags', BlogTags::class)->name('tags.index');
        Route::get('posts', BlogPosts::class)->name('posts.index');
        Route::get('posts/create', PostForm::class)->name('posts.create');
        Route::get('posts/{post}', PostForm::class)->name('posts.edit');
    });

});

require __DIR__.'/auth.php';
