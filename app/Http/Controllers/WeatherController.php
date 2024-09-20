<?php

namespace App\Http\Controllers;

use App\Services\FourSquare;
use Illuminate\Http\Request;
use App\Services\OpenWeatherMap;
use App\Http\Resources\PlacesReource;
use App\Http\Resources\WeatherForecastResource;

class WeatherController extends Controller
{
    protected $openWeather;

    public function __construct(OpenWeatherMap $openWeather)
    {
        $this->openWeather = $openWeather;
    }

    public function getWeather(Request $request)
    {
        $request->validate([
            'lon' => 'required|numeric',
            'lat' => 'required|numeric',
        ]);

        $request->merge(['units' => 'metric']);

        $getWeatherForecast = $this->openWeather->getWeatherForecast($request->lon, $request->lat, $request->except(['lon', 'lat']));
        return WeatherForecastResource::collection($getWeatherForecast);
    }
}
