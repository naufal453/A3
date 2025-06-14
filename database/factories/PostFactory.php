<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' =>
                'Haha'/*$this->faker->sentence()*/,
            'description' =>
                '123'/*$this->faker->paragraph()*/,
            'user_id' => \App\Models\User::factory(),
            'reference' =>
                $this->faker->url(),
            'genre' =>
                $this->faker->word(),
            'image_path' => null, // atau $this->faker->imageUrl() jika ingin dummy image
            'is_archived' =>
                false,
        ];
    }
}
