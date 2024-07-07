<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Resources\CountryResource;
use App\Http\Resources\CountryCollection;
use App\Models\Country;
use App\Services\CountryService;

class CountryController
{
    private $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        $countries = Country::all();

        if ($countries) {
            return new JsonResponse(['success' => true, 'data' => (new CountryCollection($countries))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }

    public function show(Request $request, $id)
    {
        $country = $this->countryService->getCountry($id);

        if ($country) {
            return new JsonResponse(['success' => true, 'data' => (new CountryResource($country))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }
}
