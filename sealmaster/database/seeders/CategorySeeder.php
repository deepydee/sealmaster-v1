<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('local')->get('public/categories.json');
        $categories = json_decode($json, true);

        foreach ($categories as $category) {
           Category::create($category);
        }

        $categories = Category::all();

        foreach ($categories as $category) {
            $category->generatePath();

            if (isset($category['thumb'])) {
                $mediaPath = storage_path("app/public/uploads/images/" . $category['thumb']);
                    $category->addMedia($mediaPath)
                        ->preservingOriginal()
                        ->toMediaCollection('categories');
            }
        }
    }
}
