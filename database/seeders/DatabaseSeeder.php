<?php

namespace Database\Seeders;

use App\Models\Freelancer;
use App\Models\Gig;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Real freelancer 2 github accounts for testing
        Freelancer::factory()
            ->has(
                Gig::factory()
                ->count(3)
                ->has(
                    Transaction::factory()->count(1)
                )
            )
            ->create([
                'github_username' => 'CarmineAkanabe'
                ]);

        Freelancer::factory()
            ->has(
                Gig::factory()
                ->count(3)
                ->has(
                    Transaction::factory()->count(1)
                )
            )
            ->create([
                'github_username' => 'SergeM101',
                ]);
        
        // The seeding nest of Freelancer for 8 random fake freelancers
        Freelancer::factory()
            ->count(7)
            ->has(
                Gig::factory()
                ->count(2)
                ->has(
                    Transaction::factory()->count(1)
                )
            )
            ->create();
    }
}
