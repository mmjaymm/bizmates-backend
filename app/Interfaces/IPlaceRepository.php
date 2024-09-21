<?php

namespace App\Interfaces;

interface IPlaceRepository
{
    const DEFAULT_SEARCH_PLACE = "Japan";

    public function getPlaces($searchPlace = self::DEFAULT_SEARCH_PLACE);
    public function getDetails($id);
    public function placeRepository($id);
}
