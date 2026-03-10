<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\GigStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gig extends Model
{
    /** @use HasFactory<\Database\Factories\GigFactory> */
    use HasFactory;

    // Fillable columns or attributes in the DB
    protected $fillable = [
        'freelancer_id',
        'title',
        'budget_usd',
        'status'
    ];

    // Used to cast the Enum to a string (singular), cases() is for all in an array
    protected $casts = ['status' => GigStatus::class];

    // A many to one relationship with a Freelancer
    public function freelancer():BelongsTo{
        return $this->belongsTo(Freelancer::class);
    }

    // One to One relationship with a transaction
    public function transaction():HasOne {
        return $this->hasOne(Transaction::class);
    }

}
