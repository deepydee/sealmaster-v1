<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Slide;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        $dmh = cache()->remember('dmh', 60 * 60 * 24, function() {
            return Category::whereSlug('manzhety-i-uplotneniya')
            ->with('children.media')
            ->get();
        });

        $goods = cache()->remember('goods', 60 * 60 * 24, function() {
            return Category::whereSlug('tovary')
            ->with('children.media')
            ->get();
        });

        $repair = cache()->remember('repair', 60 * 60 * 24, function() {
            return Category::whereSlug('remont')
            ->with('children.media')
            ->get();
        });

        $spareParts = cache()->remember('spareParts', 60 * 60 * 24, function() {
            return Category::whereSlug('remkomplekty-gidrocilindrov')
            ->with('children.media')
            ->get();
        });

        $slides = cache()->remember('slides', 60 * 60 * 24, function() {
            return Slide::with(['media'])
            ->orderBy('position', 'asc')
            ->get();
        });

        return view('index', compact('goods', 'repair', 'spareParts', 'slides', 'dmh'));
    }
}
