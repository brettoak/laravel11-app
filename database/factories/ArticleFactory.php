<?php

namespace Database\Factories;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'slug' => Str::slug($this->faker->unique()->sentence()),
            'views' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
