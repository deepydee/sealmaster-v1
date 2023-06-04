<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
       /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::defaultOrder()
            ->get()
            ->toTree();

        return view('categories.index', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        DB::transaction(function () use ($request, $category) {
            if (!$request->parent_id) {
                $category->saveAsRoot();
            }

            if ($request->shiftUp) {
                $category->up();
            }

            if ($request->shiftDown) {
                $category->down();
            }

            if ($request->parent_id
                && (int) $request->parent_id !== $category->parent_id
            ) {
                $parentNode = Category::findOrFail($request->parent_id);
                $parentNode->appendNode($category);
            }
        });

        $category->update($request->validated());

        return redirect()->route('admin.categories.index')
            ->with('message', "Категория \"{$request->title}\" успешно обновлена");
    }

     /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('message', "Категория \"{$category->title}\" успешно удалена");
    }
}
