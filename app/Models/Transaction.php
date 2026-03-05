<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    // Fillable columns or attributes in the 
    protected $fillable = [
        'amount_usd',
        'payout_xaf',
        'gateway_reference',
        'status'
    ];

    // Used to cast the Enum to a string (singular), cases() is for all in an array
    protected $casts = ['status' => TransactionStatus::class];

    // Has a one to one relationship with gig (belongs to a gig)
    public function gig():BelongsTo {
        return $this->belongsTo(Gig::class);
    }

}
