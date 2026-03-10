<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'gig_id' => $this->id,
            'title' => $this->title,
            'budget_usd' => (float)$this->budget_usd,
            'status' => $this->status->value,
            // External attributes
            'freelancer' => $this->freelancer->name,
            'transaction_status' => $this->transaction->status

            // You can use whenloaded() to prevent errors
            // 'freelancer' => $this->whenLoaded('freelancer', function () {
            //     return $this->freelancer->name;
            // }),

            // 'transaction_status' => $this->whenLoaded('escrowTransaction', function () {
            //     return $this->escrowTransaction->status;
            // }),
        ];
    }
}
