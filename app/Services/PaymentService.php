<?php

namespace App\Services;

use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
class PaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function releaseFunds(Transaction $transaction)
    {
        // Failsafe measure taken to prevent double payouts
        if ($transaction->status == 'released')
            {
                throw new Exception("Funds have already been released for this transaction");
            }

        // Default fall back rate
        $xafRate = 600.0;

        // Use a free exchange rate API
        $response = Http::get('https://open.er-api.com/v6/latest/USD');

        if ($response->successful())
            {
                $data = $response->json();
                // You can use 
                // $data = $response->json('rates.XAF');

                // This is safer
                if (isset($data['rates']['XAF'])) {
                    $xafRate = $data['rates']['XAF'];
                }
            }
        
        // Calculating Payout
        $payoutXaf = $transaction->amount_usd * $xafRate;

        // Transaction system for database
        DB::transaction(function () use ($transaction, $payoutXaf) {

            // Update transaction
            $transaction->status = 'released';
            $transaction->payout_xaf = $payoutXaf;
            $transaction->save();

            // Update associated gig
            $gig = $transaction->gig;
            $gig->status = 'completed';
            $gig->save();

        });

        return $transaction->fresh();
    }
}
