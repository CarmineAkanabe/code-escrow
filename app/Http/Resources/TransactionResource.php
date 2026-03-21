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
            'amount_usd' => (float)$this->amount_usd,
            'payout_xaf' => (float)$this->payout_xaf,
            'transaction_status' => $this->status,

            'gig' => $this->whenLoaded('gig', function () {
                return new GigSummaryResource($this->gig);
            })
        ];
    }
}
