<?php

namespace App\Http\Controllers;

use App\Services\FourSquare;
use Illuminate\Http\Request;
use App\Services\OpenWeatherMap;
use Illuminate\Support\Collection;
use App\Interfaces\IPlaceRepository;
use App\Http\Resources\PlacesReource;
use App\Exceptions\ApiCustomException;
use App\Http\Resources\PlacesPhotoResource;
use App\Http\Resources\WeatherForecastResource;

class PlacesController extends Controller
{
    const DEFAULT_SEARCH_PLACE = "Japan";
    protected $forsquare;
    protected $openWeather;
    protected $placeRepository;

    public function __construct(
        IPlaceRepository $placeRepository
    ) {
        $this->placeRepository = $placeRepository;
    }

    public function getPlaces(Request $request)
    {
        try {
            $request->mergeIfMissing(['search' => self::DEFAULT_SEARCH_PLACE]);
            $getPlaces = $this->placeRepository->getPlaces($request->search);

            return PlacesReource::collection($getPlaces);
        } catch (ApiCustomException $ex) {
            return response()->json([
                'error' => $ex->getMessage(),
                'data' => $ex->getData() ?? null,
                'status' => false
            ], 400);
        } catch (\Exception $ex) {
            return response()->json([
                'error' => $ex->getMessage() ?? "Internal Serve Error",
                'data' => null,
                'status' => false
            ], 500);
        }
    }

    public function getPhotoByPlaces($id)
    {
        try {
            $getPhoto = $this->placeRepository->placeRepository($id);
            return PlacesPhotoResource::collection($getPhoto);
        } catch (ApiCustomException $ex) {
            return response()->json([
                'error' => $ex->getMessage(),
                'data' => $ex->getData() ?? null,
                'status' => false
            ], 400);
        } catch (\Exception $ex) {
            return response()->json([
                'error' => $ex->getMessage() ?? "Internal Serve Error",
                'data' => null,
                'status' => false
            ], 500);
        }
    }

    public function getDetails($id)
    {
        try {
            $details = $this->placeRepository->getDetails($id);

            $forecast = WeatherForecastResource::collection($details['getWeatherForecast']);
            $details = new PlacesReource(array_merge($details['getDetails'], ['photos' => $details['getPhoto']], ['weather_forecast' => $forecast]));

            return $details;
        } catch (ApiCustomException $ex) {
            return response()->json([
                'error' => $ex->getMessage(),
                'data' => $ex->getData() ?? null,
                'status' => false
            ], 400);
        } catch (\Exception $ex) {
            return response()->json([
                'error' => $ex->getMessage() ?? "Internal Serve Error",
                'data' => null,
                'status' => false
            ], 500);
        }
    }
}
