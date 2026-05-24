<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostNewsFactory extends Factory
{
    public function definition(): array
    {
        $headline = fake()->sentence(6);

        return [
            'headline' => rtrim($headline, '.'),
            'slug' => Str::slug($headline) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'category_id' => Category::factory(),
            'date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'image_url' => 'images/news_images/default.jpg',
            'content' => fake()->paragraphs(3, true),
            'status' => 'published',
            'meta_title' => fake()->sentence(5),
            'meta_description' => fake()->sentence(12),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $_) => ['status' => 'draft']);
    }

    public function pending(): static
    {
        return $this->state(fn (array $_) => ['status' => 'pending']);
    }

    public function published(): static
    {
        return $this->state(fn (array $_) => ['status' => 'published']);
    }
}
