<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Models\Guest;
use App\Models\Country;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;

class GuestService {

    public function getAllGuests()
    {
        $guests = Guest::all();

        return $guests;
    }

    public function getGuest($id)
    {
        $guest = Guest::find($id);

        return $guest;
    }

    public function createGuest($data)
    {
        if (!isset($data['country_id'])) {
            $phoneNumber = $data['phone'];

            $phoneUtil = PhoneNumberUtil::getInstance();

            try {
                $phoneNumber = '+' . $phoneNumber;
                $phoneProto = $phoneUtil->parse($phoneNumber, '');
                $countryCode = $phoneUtil->getRegionCodeForNumber($phoneProto);
                $country = Country::where('code', $countryCode)->first();
                if (isset($country)) {
                    $data['country_id'] = $country->id;
                }
                else {
                    throw new HttpResponseException(
                        new JsonResponse([
                            'success' => false,
                            'errors' => ['Cтраны, которая соответствует номеру телефона, еще нет в справочнике.'],
                        ], 400));
                }
                
            } catch (NumberParseException $e) {
                throw new HttpResponseException(
                    new JsonResponse([
                        'success' => false,
                        'errors' => ['Не удалось обработать номер телефона.'],
                    ], 500));
            }
        }

        if (substr($data['phone'], 0, 1) == '+') {
            $data['phone'] = substr($data['phone'], 1);
        }

        $guest = Guest::create($data);
        
        return $guest;
    }

    public function updateGuest($id, $data)
    {
        $guest = Guest::find($id);
        
        if (array_key_exists('phone', $data) && substr($data['phone'], 0, 1) == '+') {
            $data['phone'] = substr($data['phone'], 1);
        }

        $guest->update($data);

        return $guest;
    }

    public function deleteGuest($id)
    {
        $guest = Guest::find($id);

        $deleted = $guest->delete();

        return $deleted;
    }
}