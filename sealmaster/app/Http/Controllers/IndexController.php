<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        $goods = Category::whereSlug('tovary')
            ->with('children.media')
            ->get();

        $repair = Category::whereSlug('remont')
            ->with('children.media')
            ->get();

        $spareParts = Category::whereSlug('remkomplekty-gidrocilindrov')
            ->with('children.media')
            ->get();

        return view('index', compact('goods', 'repair', 'spareParts'));
    }
}
