<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->text(30),
            'description' => fake()->text(50),
            'content' => fake()->text(300),
            'created_at' => fake()->dateTimeBetween('-20 days', '-10 days'),
        ];
    }
}
