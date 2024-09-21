<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use App\Interfaces\IApiPlaces;
use Illuminate\Support\Facades\Http;
use App\Exceptions\ApiCustomException;

class FourSquare implements IApiPlaces
{
    protected $client;

    protected $baseUri = null;
    protected $authKey = null;

    public function __construct()
    {
        $this->baseUri = config('foursquare.base_uri');
        $this->authKey = config('foursquare.auth_key');

        if ($this->baseUri == null || $this->authKey == null) {
            throw new \Exception('Foursquare config missing');
        }

        $this->client = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => $this->authKey
            ]);
    }

    public function getPlaces($place, $categories = null, $limit = 5)
    {

        $response = $this->client
            ->get($this->baseUri . '/v3/places/search', [
                'near' => $place,
                'limit' => $limit,
            ]);

        if ($response->failed()) {
            $errorData = Arr::add($response->json(), 'status', $response->successful());
            throw new ApiCustomException("Error Processing Request", $errorData);
        }

        return $response->json()['results'] ?? [];
    }

    public function getPlacesPhoto($id)
    {
        $response = $this->client->get($this->baseUri . '/v3/places/' . $id . '/photos');

        if ($response->failed()) {
            $errorData = Arr::add($response->json(), 'status', $response->successful());
            throw new ApiCustomException("Error Processing Request", $errorData);
        }

        return $response->json() ?? [];
    }

    public function getDetails($id)
    {
        $response = $this->client->get($this->baseUri . '/v3/places/' . $id);

        if ($response->failed()) {
            return Arr::add($response->json(), 'status', $response->successful());
        }

        return $response->json() ?? [];
    }
}
