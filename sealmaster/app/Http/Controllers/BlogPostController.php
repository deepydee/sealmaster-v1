<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with(['media', 'category', 'tags', 'user'])
            ->where('is_published', 1)
            ->latest()
            ->paginate(6);

        return view('front.blog.index', compact('posts'));
    }

    public function show(BlogPost $blogPost)
    {
        // $blogPost->load('user', 'category', 'media', 'tags');

        $blogPost->views++;
        $blogPost->update();

        return view('front.blog.page', compact('blogPost'));
    }
}
