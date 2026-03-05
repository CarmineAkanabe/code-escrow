<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Freelancer extends Model
{
    /** @use HasFactory<\Database\Factories\FreelancerFactory> */
    use HasFactory;

    // attributes that can be modified
    protected $fillable = [
        'name',
        'email',
        'github_username',
        'trust_score'
    ];

    // A freelancer has one or many gigs
    public function gig(): HasMany {
        // chaperone is a solution to the "N+1" query problem with one to many relations
        return $this->hasMany(Gig::class);
    }

}
