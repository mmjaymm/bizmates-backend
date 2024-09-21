<?php

namespace App\Repositories;

use App\Services\FourSquare;
use App\Services\OpenWeatherMap;
use App\Interfaces\IPlaceRepository;

class Places implements IPlaceRepository
{
    protected $forsquare;
    protected $openWeather;
    public function __construct(
        FourSquare $forsquare,
        OpenWeatherMap $openWeather
    ) {
        $this->forsquare = $forsquare;
        $this->openWeather = $openWeather;
    }

    public function getPlaces($searchPlace = self::DEFAULT_SEARCH_PLACE)
    {
        $getPlaces = $this->forsquare->getPlaces($searchPlace);

        foreach ($getPlaces as $key => $place) {
            $getPlaces[$key]['photos'] = $this->forsquare->getPlacesPhoto($place['fsq_id']);
        }

        return $getPlaces;
    }

    public function getDetails($id)
    {
        $getDetails = $this->forsquare->getDetails($id);
        $getPhoto = $this->forsquare->getPlacesPhoto($id);

        $options = [
            'units' => 'metric'
        ];

        $getWeatherForecast = $this->openWeather->getWeatherForecast(
            $getDetails['geocodes']['main']['longitude'],
            $getDetails['geocodes']['main']['latitude'],
            $options
        );

        return [
            'getWeatherForecast' => $getWeatherForecast,
            'getDetails' => $getDetails,
            'getPhoto' => $getPhoto
        ];
    }

    public function placeRepository($id)
    {
        return $this->forsquare->getPlacesPhoto($id);
    }
}
