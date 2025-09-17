<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'phase' => $this->phase,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'price' => $this->price,
        ];
    }
}
