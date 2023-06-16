<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Callback;
use App\Models\Category;
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
        $categories = Category::defaultOrder()
            ->with('children', 'parent')
            ->get()
            ->toTree();

        Facades\View::composer(
            ['front.dynamic-menu', 'front.footer'],
            function (View $view) use ($categories) {

                $view->with([
                    'categories' => $categories,
                ]);
        });

        $blogCategories = BlogCategory::select('title', 'slug')
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        $blogTags = BlogTag::all();

        Facades\View::composer(
            'front.sidebar',
            function (View $view) use ($blogCategories, $blogTags) {

            $view->with([
                'categories' => $blogCategories,
                'tags' =>  $blogTags,
            ]);
        });

        $unreadMessages = Callback::where('is_read', false)->count();

        Facades\View::composer(
            'layouts.navigation',
            function (View $view) use ($unreadMessages) {

            $view->with([
                'unreadMessages' => $unreadMessages,
            ]);
        });

        $popularPosts = BlogPost::orderBy('views', 'desc')
            ->with('media', 'category:id,slug,title', 'user:id,name')
            ->limit(4)
            ->get();

        Facades\View::composer(
            'front.popular-posts',
            function (View $view) use ($popularPosts) {

            $view->with([
                'popularPosts' => $popularPosts,
            ]);
        });
    }
}
