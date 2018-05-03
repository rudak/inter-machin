<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\City;
use AppBundle\Entity\Trade\Resource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ResourceFixtures extends Fixture
{
    const RESOURCE_NAME     = 'name';
    const RESOURCE_VALUE    = 'value';
    const RESOURCE_QUANTITY = 'quantity';
    const RESOURCE_COEF     = 'coef';

    public function load(ObjectManager $manager)
    {
        foreach ($this->getResourcesData() as $data) {
            $resource = new Resource();
            $resource->setName($data[self::RESOURCE_NAME]);
            $resource->setValue($data[self::RESOURCE_VALUE]);
            $resource->setDefault($data[self::RESOURCE_VALUE]);
            $resource->setQuantity($data[self::RESOURCE_QUANTITY]);
            $resource->setCoef($data[self::RESOURCE_COEF]);
            $manager->persist($resource);
        }
        $manager->flush();
    }

    private function getResourcesData()
    {
        return [
            [
                self::RESOURCE_NAME     => 'antimatière',
                self::RESOURCE_VALUE    => 5000,
                self::RESOURCE_QUANTITY => 50000,
                self::RESOURCE_COEF     => 90,
            ],
            [
                self::RESOURCE_NAME     => 'rhodium',
                self::RESOURCE_VALUE    => 4000,
                self::RESOURCE_QUANTITY => 50000,
                self::RESOURCE_COEF     => 80,
            ],
            [
                self::RESOURCE_NAME     => 'diamant',
                self::RESOURCE_VALUE    => 3000,
                self::RESOURCE_QUANTITY => 50000,
                self::RESOURCE_COEF     => 60,
            ],
            [
                self::RESOURCE_NAME     => 'acier',
                self::RESOURCE_VALUE    => 700,
                self::RESOURCE_QUANTITY => 50000,
                self::RESOURCE_COEF     => 40,
            ],
            [
                self::RESOURCE_NAME     => 'plastique',
                self::RESOURCE_VALUE    => 100,
                self::RESOURCE_QUANTITY => 50000,
                self::RESOURCE_COEF     => 20,
            ],
            [
                self::RESOURCE_NAME     => 'carton',
                self::RESOURCE_VALUE    => 10,
                self::RESOURCE_QUANTITY => 50000,
                self::RESOURCE_COEF     => 10,
            ],
        ];
    }
}