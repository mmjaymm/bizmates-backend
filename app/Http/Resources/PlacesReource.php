<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlacesReource extends JsonResource
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
            'id'    => $this['fsq_id'],
            'name'  => $this['name'],
            'link'  => $this['link'],
            'location' => $this['location'],
            'categories' => CategoriesPlacesReource::collection($this['categories'] ?? []),
            'related_places' => RelatedPlacesReource::collection($this['related_places']['children'] ?? []),
            'latitude' => $this['geocodes']['main']['latitude'],
            'longitude' => $this['geocodes']['main']['longitude'],
            'photos' => PlacesPhotoResource::collection($this['photos'] ?? []),
            'weather_forecast' => WeatherForecastResource::collection($this['weather_forecast'] ?? []),
        ];
    }
}
