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
            'short_name'  => $this['categories']['short_name'] ?? '',
            'icon'  => ($this['categories'][0]['icon']['prefix'] . '120' . $this['categories'][0]['icon']['suffix']) ?? '',
            // 'categories' => CategoriesPlacesReource::collection($this['categories'] ?? []),
        ];
    }
}
