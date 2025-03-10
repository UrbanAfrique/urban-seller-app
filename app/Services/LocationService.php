<?php

namespace App\Services;

use App\Models\Country;

class LocationService
{
    public static function countryDropdown()
    {
        return Country::pluck('name','code');
    }

}
