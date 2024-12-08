<?php

namespace App\Helper;

use Sweet0dream\IntimAnketaContract;

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
            'route' => $this->getRouteCity($domain['route']),
            'name' => $this->getNameCity($city['value']),
            'meta' => $this->getMetaCity($domain['route'], $city['value']),
            'rao' => explode(',', $city['rao']),
            'timezone' => $city['timezone'],
            'user' => [
                'price' => $city['price'],
                'start_balance' => $city['user_start_balance'],
            ]
        ];
    }

    private function getRouteCity(string $route): array
    {
        return json_decode($route, true);
    }

    private function getNameCity(string $value): array
    {
        return explode('/', $value);
    }

    private function getMetaCity(
        string $route,
        string $city
    ): array
    {
        $city = $this->getNameCity($city);
        return array_combine(
            array_values($this->getRouteCity($route)),
            array_map(function($v) use ($city) {
                return array_merge(
                    array_map(
                        function($i) use ($v) {
                            return $v[1] . ' ' . $i;
                        },
                        $city
                    ),
                    ['item' => $v]
                );
            }, IntimAnketaContract::META)
        );
    }
}