<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FreelancerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'github_username' => $this->github_username,
            'trust_score' => $this->trust_score,

            // This is for nested Gigs, but puts in all gig details. We don't need that
            'gigs' => GigSummaryResource::collection($this->whenLoaded('gig'))

        ];
    }
}
