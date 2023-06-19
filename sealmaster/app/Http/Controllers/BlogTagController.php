<?php

namespace App\Http\Controllers;

use App\Models\BlogTag;

class BlogTagController extends Controller
{
    public function show(BlogTag $blogTag) {

        $posts = $blogTag->posts()
            ->where('is_published', 1)
            ->with('category', 'media', 'user:id,name')
            ->latest()
            ->paginate(4);

            return view(
                'front.blog.tag',
                ['tag' => $blogTag, 'posts' => $posts]
            );
    }
}
