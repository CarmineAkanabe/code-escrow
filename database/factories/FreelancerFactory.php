<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Freelancer>
 */
class FreelancerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // This is the structure of the factory using the laravel faker library
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'github_username' => fake()->unique()->userName(),
            'trust_score' => 0, // Will be used to count repos
        ];
    }
}
