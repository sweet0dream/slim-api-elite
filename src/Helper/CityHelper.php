<?php

namespace App\Helper;

class CityHelper
{
    public function prepareConfigCity(
        ?array $domain,
        ?array $city
    ): ?array
    {
        if (is_null($domain) || is_null($city)) {
            return null;
        }

        return [
            'id' => $city['id'],
            'value' => $domain['value'],
            'key' => $city['name'],
            'route' => json_decode($domain['route'], true),
            'name' => explode('/', $city['value']),
            'rao' => explode(',', $city['rao']),
            'timezone' => $city['timezone'],
            'user' => [
                'price' => $city['price'],
                'start_balance' => $city['user_start_balance'],
            ]
        ];
    }
}