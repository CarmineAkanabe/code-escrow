<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Mail\PayoutReleasedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PayoutReleaseMail;

class SendPayoutEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Transaction $transaction;
    /**
     * Create a new job instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // This is the mail dispatch
        $transaction = $this->transaction->load('gig.freelancer');

        if (!$transaction->gig || !$transaction->gig->freelancer) {
            return; // silently skip instead of crashing queue
        }

        Mail::to($transaction->gig->freelancer->email)
            ->send(new PayoutReleaseMail($transaction));
    }
}
