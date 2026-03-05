<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\TransactionStatus;
use App\Models\Gig;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // We must specify the foreign key
            // 'gig_id' => Gig::factory(),

            'amount_usd' => fake()->randomFloat(2, 50, 5000), // from 50 to 5000 with 2 dec points
            'payout_xaf' => null, // calculated later by API
            'status' => fake()->randomElement(TransactionStatus::cases())->value  // Grabs the Enum class
        ];
    }
}
