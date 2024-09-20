<?php

namespace App\Services;

use Illuminate\Support\Arr;
use App\Interfaces\IApiPlaces;
use Illuminate\Support\Facades\Http;

class Geoapify implements IApiPlaces
{
    protected $client;

    protected $baseUri = null;
    protected $authKey = null;

    public function __construct()
    {
        $this->baseUri = config('geoapify.base_uri');
        $this->authKey = config('geoapify.api_key');

        if ($this->baseUri == null || $this->authKey == null) {
            throw new \Exception('Geoapify config missing');
        }

        $this->client = Http::accept('application/json');
    }

    public function getPlaces($filter, $categories = null, $limit = 10)
    {

        $response = $this->client
            ->get($this->baseUri . '/v2/places', [
                'categories' => $categories,
                'filter' => $filter,
                'limit' => $limit,
                'apiKey' => $this->authKey,
            ]);

        if ($response->failed()) {
            return Arr::add($response->json(), 'status', $response->successful());
        }

        return $response->json()['features'] ?? [];
    }
}
