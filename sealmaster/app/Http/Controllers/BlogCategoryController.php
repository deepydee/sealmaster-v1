<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    function show (BlogCategory $blogCategory) {

        // $blogCategory->load('posts');

        $posts = $blogCategory->posts()
            ->with('category', 'user:id,name', 'media')
            ->latest()
            ->paginate(4);

        return
            view('front.blog.category',
            ['category' => $blogCategory, 'posts' => $posts]
        );
    }
}
