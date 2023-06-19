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
        $categories = cache()->remember('vsp-categories', 60 * 60 * 24, function() {
            return Category::defaultOrder()
            ->with('children', 'parent')
            ->get()
            ->toTree();
        });

        Facades\View::composer(
            ['front.dynamic-menu', 'front.footer'],
            function (View $view) use ($categories) {

                $view->with([
                    'categories' => $categories,
                ]);
        });

        $blogCategories = cache()->remember('vsp-blogCategories', 60 * 60 * 24, function() {
            return BlogCategory::select('title', 'slug')
            ->whereRelation('posts', 'is_published', 1)
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();
        });

        $blogTags = cache()->remember('vsp-blogTags', 60 * 60 * 24, function() {
            return BlogTag::whereRelation('posts', 'is_published', 1)->get();
        });

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

        $popularPosts = cache()->remember('vsp-popularPosts', 60 * 60 * 24, function() {
            return BlogPost::where('is_published', 1)
			->orderBy('views', 'desc')
            ->with('media', 'category:id,slug,title', 'user:id,name')
            ->limit(4)
            ->get();
        });

        Facades\View::composer(
            'front.popular-posts',
            function (View $view) use ($popularPosts) {

            $view->with([
                'popularPosts' => $popularPosts,
            ]);
        });
    }
}
