<?php

namespace App\Services;

use App\Models\Gig;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class GigManagementService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createGig(array $data): Gig {

        // For better security using DBA concept of transactions, wrap everythig with the DB::transaction function
        return DB::transaction(function () use ($data) {

            // This is used to create the gig class and insert data from the $validatedData array
            $gig = Gig::create([
                'freelancer_id' => $data['freelancer_id'],
                'title' => $data['title'],
                'budget_usd' => $data['budget_usd'],
                'status' => 'open'
            ]);

            // After the gig class is initiated we auto create a transaction linked to it
            Transaction::create([
                'gig_id' => $gig->id,
                'amount_usd' => $gig->budget_usd,
                'status' => 'held',
                'payout_xaf' => null
            ]);

            return $gig;
        });
    }
}
