<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('local')->get('public/kastas_catalog.json');
        $productsAll = json_decode($json, true);

        $products = [];
        $attributeValues = [];

        foreach ($productsAll as $item) {
            $products[] = [
                'code' => $item['code'] ?? null,
                'title' => $item['title'] ?? null,
                'description' => $item['description'] ?? null,
                'thumb' => $item['thumb'] ?? null,
                'category' => $item['category'] ?? null,
            ];

            $attributeValues[] = [
                'code' => $item['code'] ?? null,
                'benefits' => $item['benefits'] ?? null,
                'area' => $item['area'] ?? null,
                'material' => $item['material'] ?? null,
                'max_pressure' => $item['max_pressure'] ?? null,
                'max_temp' => $item['max_temp'] ?? null,
                'sliding_speed' => $item['sliding_speed'] ?? null,
                'tech_drawing' => $item['tech_drawing'] ?? null,
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

        foreach ($attributeValues as $value) {
            $code = $value['code'];

            Product::whereCode($code)
                ->firstOrFail()
                ->attributes()
                ->sync([
                    1 => [ 'value' => $value['benefits'] ],
                    2 => [ 'value' => $value['area'] ],
                    3 => [ 'value' => $value['material'] ],
                    4 => [ 'value' => $value['max_pressure'] ],
                    5 => [ 'value' => $value['max_temp'] ],
                    6 => [ 'value' => $value['sliding_speed'] ],
                    7 => [ 'value' => $value['tech_drawing'] ],
                ]);
        }
    }
}
