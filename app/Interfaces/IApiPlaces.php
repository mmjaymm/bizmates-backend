<?php

namespace App\Interfaces;

interface IApiPlaces
{
    public function getPlaces($filter, $categories = null, $limit = 10);
}
