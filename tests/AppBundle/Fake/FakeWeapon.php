<?php

namespace Tests\AppBundle\Fake;

use AppBundle\Entity\Weapon;

class FakeWeapon implements FakeObjectsInterface
{
    private static $object;

    public static function getObject($forceNew = false, $price = 150, $uses = 2, $lvl = 3, $attackDef = 20)
    {
        if (null == self::$object || $forceNew) {
            $weapon = new Weapon();
            $weapon->setPrice($price);
            $weapon->setName(self::getRandName());
            $weapon->setAttack($attackDef);
            $weapon->setDefense($attackDef);
            $weapon->setLvl($lvl);
            $weapon->setUses($uses);
            self::$object = $weapon;
        }
        return self::$object;
    }

    private static function getRandName()
    {
        return self::getNames() . self::getNames();
    }

    private static function getNames()
    {
        $names = ['dogh', 'trech', 'pan', 'sac', 'vile', 'daar', 'milh', 'zine', 'chew', 'klaz','mia','jun','poo','fiz'];
        return $names[array_rand($names)];
    }
}