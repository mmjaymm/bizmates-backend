<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlacesPhotoResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        self::withoutWrapping();
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this['id'],
            'created_at'  => $this['created_at'],
            'width'  => $this['width'],
            'height'  => $this['height'],
            'image'  => $this['prefix'] . 'original' . $this['suffix']
        ];
    }
}
