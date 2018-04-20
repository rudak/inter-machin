<?php

namespace Tests\AppBundle\Fake;

use AppBundle\Entity\City;

class FakeCity
{
    private static $city;

    public static function getObject($name = 'fakeCity', $price = 666, $forceNew = false)
    {
        if (null === self::$city || true === $forceNew) {
            self::$city = new City();
            self::$city->setName($name);
            self::$city->setPrice($price);
        }
        return self::$city;
    }
}