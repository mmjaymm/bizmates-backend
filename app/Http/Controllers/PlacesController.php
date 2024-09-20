<?php

namespace App\Http\Controllers;

use App\Services\FourSquare;
use Illuminate\Http\Request;
use App\Services\OpenWeatherMap;
use Illuminate\Support\Collection;
use App\Http\Resources\PlacesReource;
use App\Http\Resources\PlacesPhotoResource;
use App\Http\Resources\WeatherForecastResource;

class PlacesController extends Controller
{
    const DEFAULT_SEARCH_PLACE = "Japan";
    protected $forsquare;
    protected $openWeather;

    public function __construct(
        FourSquare $forsquare,
        OpenWeatherMap $openWeather
    ) {
        $this->forsquare = $forsquare;
        $this->openWeather = $openWeather;
    }

    public function getPlaces(Request $request)
    {
        $request->mergeIfMissing(['search' => self::DEFAULT_SEARCH_PLACE]);
        $getPlaces = $this->forsquare->getPlaces($request->search);

        return PlacesReource::collection($getPlaces);
    }

    public function getPhotoByPlaces($id)
    {
        $getPhoto = $this->forsquare->getPlacesPhoto($id);
        return PlacesPhotoResource::collection($getPhoto);
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

        $forecast = WeatherForecastResource::collection($getWeatherForecast);
        $details = new PlacesReource(array_merge($getDetails, ['photos' => $getPhoto], ['weather_forecast' => $forecast]));

        return $details;
    }
}
