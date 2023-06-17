<?php

namespace App\Console\Commands;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically Generate an XML Sitemap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        Category::get()->each(function (Category $category) use ($sitemap) {
            $sitemap->add(
                Url::create($category->path)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        Product::with('categories')->get()->each(function (Product $product) use ($sitemap) {
            $sitemap->add(
                Url::create($product->categories()->first()->path.'/'.$product->slug)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        BlogCategory::get()->each(function (BlogCategory $category) use ($sitemap) {
            $sitemap->add(
                Url::create('/blog/category/'.$category->slug)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        BlogTag::get()->each(function (BlogTag $tag) use ($sitemap) {
            $sitemap->add(
                Url::create('/blog/tag/'.$tag->slug)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        BlogPost::get()->each(function (BlogPost $post) use ($sitemap) {
            $sitemap->add(
                Url::create('/blog/article/'.$post->slug)
                    ->setLastModificationDate(Carbon::yesterday())
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
