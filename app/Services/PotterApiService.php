<?php

namespace App\Services;

use App\Services\Interfaces\IPotterApiService;
use Illuminate\Support\Facades\Http;

class PotterApiService implements IPotterApiService
{

    public function getHouseData(string $house)
    {
        $housePath = 'houses/';
        return Http::get(env('POTTERAPI_BASE_URL').
            $housePath.
            $house.
            '?key='.
            env('POTTERAPI_KEY'));
    }
}
