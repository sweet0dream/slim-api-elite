<?php

namespace App\Service;

use App\Helper\CityHelper;
use App\Repository\CityRepository;
use App\Repository\DomainRepository;

class CityService
{
    private string $domain;
    private DomainRepository $domainRepository;
    private CityRepository $cityRepository;
    private CityHelper $cityHelper;
    public function __construct(string $domain)
    {
        $this->domain = $domain;
        $this->domainRepository = new DomainRepository();
        $this->cityRepository = new CityRepository();
        $this->cityHelper = new CityHelper();
    }

    public function getCity(): ?array
    {
        $domain = $this->domainRepository->findOneBy(['value' => $this->domain]);
        if (!is_null($domain)) {
            $city = $this->cityRepository->findOne((int)$domain['city_id']);
        }

        return $this->cityHelper->prepareConfigCity($domain, $city ?? null);
    }
}