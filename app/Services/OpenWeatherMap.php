<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class OpenWeatherMap
{
    const DEFAULT_LIMIT = 5;
    protected $client;
    protected $baseUri = null;
    protected $authKey = null;

    public function __construct()
    {
        $this->baseUri = config('openweathermap.base_uri');
        $this->authKey = config('openweathermap.api_key');

        if ($this->baseUri == null || $this->authKey == null) {
            throw new \Exception('Open Weather Map config missing');
        }

        $this->client = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => $this->authKey
            ]);
    }

    public function getWeatherForecast($lon, $lat, $options = [])
    {
        $options = array_merge([
            'cnt' => self::DEFAULT_LIMIT
        ]);

        $response = $this->client
            ->get($this->baseUri . '/data/2.5/forecast', [
                'lon' => $lon,
                'lat' => $lat,
                'appid' => $this->authKey,
                ...$options
            ]);

        if ($response->failed()) {
            return Arr::add($response->json(), 'status', $response->successful());
        }

        return $response->json()['list'] ?? [];
    }
}
