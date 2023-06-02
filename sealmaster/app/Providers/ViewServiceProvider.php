<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Facades\View::composer('front.sidebar', function (View $view) {
            $categories = BlogCategory::withCount('posts')
                ->orderBy('posts_count', 'desc')
                ->get();

            $tags = BlogTag::all();

            $view->with([
                'categories' => $categories,
                'tags' =>  $tags,
            ]);
        });

        Facades\View::composer('front.popular-posts', function (View $view)
        {
            $popularPosts = BlogPost::orderBy('views', 'desc')
                ->with('media', 'category')
                ->limit(3)
                ->get();

            $view->with([
                'popularPosts' => $popularPosts,
            ]);
        });
    }
}
