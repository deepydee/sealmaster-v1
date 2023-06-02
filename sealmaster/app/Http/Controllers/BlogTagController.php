<?php

namespace App\Http\Controllers;

use App\Models\BlogTag;

class BlogTagController extends Controller
{
    public function show(BlogTag $blogTag) {

        $posts = $blogTag->posts()
            ->with('category')
            ->latest()
            ->paginate(4);

            return view(
                'front.blog.tag',
                ['tag' => $blogTag, 'posts' => $posts]
            );
    }
}
