<?php

namespace Tests\AppBundle;

use AppBundle\Entity\City;

class CityHelper
{
    private static $city;

    public static function getFakeCity($name = 'fakeCity', $price = 666, $forceNew = false)
    {
        if (null === self::$city || true === $forceNew) {
            self::$city = new City();
            self::$city->setName($name);
            self::$city->setPrice($price);
        }
        return self::$city;
    }
}