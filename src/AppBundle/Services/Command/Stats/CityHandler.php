<?php

namespace AppBundle\Services\Command\Stats;

use AppBundle\Entity\City;
use AppBundle\Entity\Stats\CityStatus;
use AppBundle\Services\Command\CronEmCommand;

class CityHandler extends CronEmCommand
{
    public function execute()
    {
        $cities = $this->em->getRepository(City::class)->findAll();
        foreach ($cities as $city) {
            $this->setCityStatus($city);
        }
        $this->em->flush();
    }

    private function setCityStatus(City $city)
    {
        $this->em->persist(new CityStatus($city, $city->getUsers()->count(), $city->getPrice()));
    }
}