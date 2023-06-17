<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = BlogTag::factory(5)->create();

        BlogCategory::factory()
            ->count(5)
            ->create()
            ->each(function($category) use($tags) {
                BlogPost::factory()
                    ->count(rand(2, 4))
                    ->create([
                        'blog_category_id' => $category->id
                    ])->each(function($post) use ($tags) {
                        $post->tags()->attach($tags->random(5));
            });
        });;
    }
}
