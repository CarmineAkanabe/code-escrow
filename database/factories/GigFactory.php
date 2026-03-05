<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\GigStatus;
use App\Models\Freelancer;
use App\Models\Transaction;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gig>
 */
class GigFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // We must always include foreign keys
            // 'developer_id' => Freelancer::factory(),
            // 'transactions_id' => Transaction::factory(),

            'title' => fake()->jobTitle(),  // or catchPhrase()
            'budget_usd' => fake()->randomFloat(2, 50, 5000), // from 50 to 5000 with 2 dec points
            'status' => fake()->randomElement(GigStatus::cases())->value // Grabs the Enum class
        ];
    }
}
