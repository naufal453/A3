<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chapter>
 */
class ChapterFactory extends Factory
{
    protected $model = Chapter::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => '1'/*$this->faker->unique()->numberBetween(1, 1000)*/,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
        ];
    }
}
