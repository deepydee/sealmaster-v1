<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogSearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'required',
        ]);

        $q = $request->q;

        $posts = BlogPost::search($q)
            ->with('category')
            ->paginate(4);

        return view('front.blog.search', compact('posts', 'q'));
    }
}
