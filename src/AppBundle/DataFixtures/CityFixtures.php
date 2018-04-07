<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    const NAME_INDEX = 'name';
    const FIRST_CITY = 'FIRST_CITY';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getCitysData() as $index => $cityData) {
            $city = new City();
            $city->setName($cityData[self::NAME_INDEX]);
            $city->setPrice(rand(500, 600));
            if ($index == 0) {
                $this->addReference(self::FIRST_CITY, $city);
            }
            $manager->persist($city);
        }
        $manager->flush();
    }

    private function getCitysData()
    {
        return [
            [
                self::NAME_INDEX => 'Helsinki',
            ],
            [
                self::NAME_INDEX => 'Moscou',
            ],
            [
                self::NAME_INDEX => 'Berlin',
            ],
            [
                self::NAME_INDEX => 'Tokyo',
            ],
            [
                self::NAME_INDEX => 'Rio',
            ],
            [
                self::NAME_INDEX => 'Denver',
            ],
            [
                self::NAME_INDEX => 'Nairobi',
            ],
        ];
    }
}