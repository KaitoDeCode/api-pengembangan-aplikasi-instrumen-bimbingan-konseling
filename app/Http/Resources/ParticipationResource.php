<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'instrument_id' => $this->instrument_id,
            'group_id' => $this->group_id,
            'user_id' => $this->user_id,
            'criteria_id' => $this->criteria_id,
            'point' => $this->point,
        ];
    }
}
