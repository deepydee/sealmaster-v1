<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DMHSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('local')->get('public/dmh.json');
        $productsAll = json_decode($json, true);

        $products = [];

        foreach ($productsAll as $item) {
            $products[] = [
                'code' => $item['code'] ?? null,
                'title' => $item['title'] ?? null,
                'thumb' => $item['thumb'] ?? null,
                'category' => $item['category'] ?? null,
            ];
        }

        foreach ($products as $product) {
            $slug = SlugService::createSlug(
                Category::class,
                'slug',
                $product['category'],
                ['unique' => false],
            );

            unset($product['category']);

            if (isset($product['thumb'])) {
                $mediaPath = storage_path("app/public/uploads/images/" . $product['thumb']);
            } else {
                $mediaPath = null;
            }

            unset($product['thumb']);

            Product::factory()->create($product)
                ->categories()
                ->sync(Category::whereSlug($slug)->first());

            if (file_exists($mediaPath)) {
                Product::whereCode($product['code'])->firstOrFail()
                    ->addMedia($mediaPath)
                    ->preservingOriginal()
                    ->toMediaCollection('products');
            }
        }
    }
}
