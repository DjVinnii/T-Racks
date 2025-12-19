<?php

namespace App\Http\Resources;

use App\Models\Rack;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Rack */
class RackResource extends JsonResource
{
    /**
     * Transform the resource into an array. 
     * 
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'location_id' => $this->location_id,
            'location' => $this->whenLoaded('location', function () {
                return [
                    'id' => $this->location?->id,
                    'name' => $this->location?->name,
                ];
            }),
            'name' => $this->name,
            'notes' => $this->notes,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
