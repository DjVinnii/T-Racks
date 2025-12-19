<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'rack_id' => $this->rack_id,
            'rack' => $this->whenLoaded('rack', function () {
                return [
                    'id' => $this->rack?->id,
                    'name' => $this->rack?->name,
                ];
            }),
            'name' => $this->name,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
