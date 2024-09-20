<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RelatedPlacesReource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this['fsq_id'],
            'name'  => $this['name'],
            'categories' => CategoriesPlacesReource::collection($this['categories'] ?? []),
        ];
    }
}
