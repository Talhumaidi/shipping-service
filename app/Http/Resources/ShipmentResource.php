<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid
        ];
    }
}
