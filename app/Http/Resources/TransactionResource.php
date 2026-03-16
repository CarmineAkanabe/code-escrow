<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount_usd' => $this->amount_usd,
            'payout_xaf' => $this->payout_xaf,
            'status' => $this->status,

            'gig' => [
                'title' => $this->gig->title,
                'status' => $this->gig->status,
            ]
        ];
    }
}
