<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CityFixtures extends Fixture
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getCitysData() as $cityData) {
            $city = new City();
            $city->setName($cityData['name']);
            $city->setPrice(rand(100, 400));
            $manager->persist($city);
        }
        $manager->flush();
    }

    private function getCitysData()
    {
        return [
            [
                'name' => 'Montcuq',
            ],
            [
                'name' => 'Bouc-Étourdi',
            ],
            [
                'name' => 'Arnac-la-Poste',
            ],
            [
                'name' => 'Bezons',
            ],
            [
                'name' => 'Longcochon',
            ],
            [
                'name' => 'Condom',
            ],
            [
                'name' => 'Sainte-Verge',
            ],
            [
                'name' => 'Monteton',
            ],
            [
                'name' => 'Bidon',
            ],
            [
                'name' => 'Fourequeux',
            ],
            [
                'name' => 'Bourré',
            ],
            [
                'name' => 'Glandage',
            ],
            [
                'name' => 'Poil',
            ],
            [
                'name' => 'Vatan',
            ],
            [
                'name' => 'Trécon',
            ],
            [
                'name' => 'Saleich',
            ],
            [
                'name' => 'Belbèze',
            ],
            [
                'name' => 'Kaunas',
            ],
        ];
    }
}