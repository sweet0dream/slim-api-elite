<?php

namespace App\Service;

use App\Repository\CityRepository;
use App\Repository\DomainRepository;

class CityService
{
    private string $domain;
    private DomainRepository $domainRepository;
    private CityRepository $cityRepository;
    public function __construct(string $domain)
    {
        $this->domain = $domain;
        $this->domainRepository = new DomainRepository();
        $this->cityRepository = new CityRepository();
    }

    public function getCity(): ?array
    {
        $city = $this->cityRepository->findOne(
            (int)$this->domainRepository->findOneBy(['value' => $this->domain])[0]['city_id']
        );

        return !empty($city) ? $city[0] : null;
    }
}