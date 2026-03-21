<?php

namespace App\Services;

use App\Models\Transaction;
use App\Enums\TransactionStatus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendPayoutEmailJob;
use Exception;

class PaymentService
{
    public function releaseFunds(Transaction $transaction): Transaction
    {
        // 🔒 Failsafe
        if ($transaction->status === TransactionStatus::RELEASED) {
            throw new Exception("Funds have already been released for this transaction.");
        }

        // 🌍 Exchange Rate API
        $response = Http::get('https://open.er-api.com/v6/latest/USD');

        if ($response->successful()) {
            $rate = $response->json()['rates']['XAF'] ?? 600.00;
        } else {
            // ⚠️ Fallback
            $rate = 600.00;
        }

        // 💰 Calculation
        $payoutXaf = $transaction->amount_usd * $rate;

        // 🧠 Critical Section (DB Transaction)
        DB::transaction(function () use ($transaction, $payoutXaf) {

            // Update Transaction
            $transaction->update([
                'status' => TransactionStatus::RELEASED,
                'payout_xaf' => $payoutXaf,
            ]);

            // Update related Gig
            $transaction->gig->update([
                'status' => 'completed'
            ]);
        });

        // 📦 Dispatch Job (ASYNC EMAIL)
        SendPayoutEmailJob::dispatch($transaction);

        return $transaction->fresh(); // 🔁 return updated version
    }
}