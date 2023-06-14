<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogTagController;
use App\Http\Controllers\BlogSearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Attributes\AttributeList;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Blog\BlogCategories;
use App\Http\Livewire\Blog\BlogTags;
use App\Http\Livewire\Blog\BlogPosts;
use App\Http\Livewire\Blog\PostForm;
use App\Http\Livewire\Categories\CategoryForm;
use App\Http\Livewire\Products\ProductForm;
use App\Http\Livewire\Products\ProductList;
use App\Http\Livewire\Slider\SlideForm;
use App\Http\Livewire\Slider\Slides;
use App\Http\Livewire\Users\UserList;

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

Route::middleware(['admin'])->prefix('admin')->group(function () {
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

    Route::name('admin.')->group(function () {
        Route::get('/users', UserList::class)->name('users.index');

        Route::get('/categories/create/{category?}', CategoryForm::class)
            ->name('categories.create');
        Route::resource('/categories', AdminCategoryController::class)
            ->only('index', 'update', 'destroy');

        Route::get('/attributes', AttributeList::class)->name('attributes.index');

        Route::get('/products', ProductList::class)->name('products.index');
        Route::get('/products/create', ProductForm::class)->name('products.create');
        Route::get('/products/{product}', ProductForm::class)->name('products.edit');

        // Route::middleware(['can:viewAny'])->group(function () {
            Route::get('/slides', Slides::class)->name('slides.index');
            Route::get('/slides/create', SlideForm::class)->name('slides.create');
            Route::get('/slides/{slide}', SlideForm::class)->name('slides.edit');
        // });
    });

});

require __DIR__.'/auth.php';

Route::get('/{category_path}/{product}', [ProductController::class, 'show'])
    ->where('category_path', '[a-zA-Z0-9/_-]+')
    ->where('product', '[0-9]+-[a-zA-Z0-9_-]+')
    ->name('products.show');

Route::get('/{path}', [CategoryController::class, 'show'])
    ->where('path', '[a-zA-Z0-9/_-]+')
    ->name('category.show');
