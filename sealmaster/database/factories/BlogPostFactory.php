<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->realText(),
            'keywords' => join(',', fake()->words(fake()->numberBetween(3, 9))),
            'content' => fake()->realText(3000),
            'blog_category_id' => BlogCategory::factory(),
            'user_id' => User::factory(),
            'views' => fake()->randomNumber(5, false),
            'is_published' => fake()->randomElement([0 , 1]),
            'created_at' => fake()->unixTime(),
            'updated_at' => fake()->unixTime(),
        ];
    }
}
