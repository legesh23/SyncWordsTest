<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_title' => trim($this->event_title),
            'event_start_date' => $this->event_start_date,
            'event_end_date' => $this->event_end_date,
            'organization_id' => $this->organization_id,
        ];
    }
}
