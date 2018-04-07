<?php

namespace AppBundle\Services\Command;

use AppBundle\Entity\City;

class CityPrices extends CronEmCommand
{
    const PRICE_VARIATION = 10;

    /**
     * Modification des prix des villes
     */
    public function update()
    {
        $cities = $this->em->getRepository(City::class)->findAll();
        foreach ($cities as $city) {
            $this->updatePrice($city);
        }
        $this->em->flush();
    }

    private function updatePrice(City $city)
    {
        $city->setPrice(
            $this->checkPriceValues(
                $city->getPrice() + (rand(0, self::PRICE_VARIATION * 2) - self::PRICE_VARIATION)
            )
        );
        $this->em->persist($city);
    }

    /**
     * Verifie si les prix sont pas inf au min ou sup au max
     * @param $price
     * @return int
     */
    private function checkPriceValues($price)
    {
        return $price < City::MIN_PRICE ? City::MIN_PRICE : $price > City::MAX_PRICE ? City::MAX_PRICE : $price;
    }
}