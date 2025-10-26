<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'article_id' => Article::query()->inRandomOrder()->first()->id ?? Article::factory(),
            'user_id' => User::query()->inRandomOrder()->first()->id ?? User::factory(),
            'content' => $this->faker->paragraph(),
        ];
    }
}
