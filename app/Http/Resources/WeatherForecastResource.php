<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherForecastResource extends JsonResource
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
            'time'     => Carbon::createFromTimestamp($this['dt'])->format('Y-m-d H:i:s'),
            'temp'     => floor($this['main']['temp']) . '°',
            'temp_min' => floor($this['main']['temp_min']) . '°',
            'temp_max' => floor($this['main']['temp_max']) . '°',
            'weather'  => [
                'name'          => $this['weather'][0]['main'],
                'description'   => $this['weather'][0]['description'],
                'icon'          => config('openweathermap.icon_url') . $this['weather'][0]['icon'] . '@2x.png'
            ]
        ];
    }
}
