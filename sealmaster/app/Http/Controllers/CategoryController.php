<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('index')->with('name', 'home');
    }

    public function show(string $path): View
    {
        $category = Category::wherePath($path)
            ->with(['children.media']) // 'products.attributes'
            ->firstOrFail();

        // $products = $category->products()
        //     ->with('attributes', 'media')
        //     ->paginate(16);

        return view('front.categories.show', compact('category')); //, 'products'
    }
}
