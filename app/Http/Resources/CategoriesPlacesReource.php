<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesPlacesReource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this['id'],
            'name'  => $this['name'],
            'short_name' => $this['short_name'] ?? '',
            'plural_name' => $this['plural_name'] ?? '',
            'icon' => $this['icon']['prefix'] . $this['icon']['suffix'] ?? ''
        ];
    }
}
