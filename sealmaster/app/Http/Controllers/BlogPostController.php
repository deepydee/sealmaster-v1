<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = cache()->remember('blog-posts', 60 * 60 * 24, function() {
            return BlogPost::where('is_published', 1)
            ->with(['media', 'category:id,title,slug', 'user:name,id'])
            ->latest()
            ->paginate(6);
        });

        return view('front.blog.index', compact('posts'));
    }

    public function show(BlogPost $blogPost)
    {
        $blogPost->views++;
        $blogPost->update();

        return view('front.blog.page', compact('blogPost'));
    }
}
