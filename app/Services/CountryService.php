<?php

namespace App\Services;

use App\Models\Country;

class CountryService {

    public function getAllCountries()
    {
        $countries = Country::all();

        return $countries;
    }

    public function getCountry($id)
    {
        $country = Country::find($id);
        
        return $country;
    }
}