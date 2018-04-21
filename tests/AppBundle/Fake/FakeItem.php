<?php

namespace Tests\AppBundle\Fake;

use AppBundle\Entity\Item;

class FakeItem implements FakeObjectsInterface
{

    private static $object;

    public static function getObject($active = true, $forceNew = false)
    {
        if (null == self::$object || $forceNew) {
            $weapon = FakeWeapon::getObject($forceNew);
            $item   = new Item();
            $item->setWeapon($weapon);
            $item->setPrice($weapon->getPrice());
            $item->setActive($active);
            self::$object = $item;
        }
        return self::$object;
    }
}