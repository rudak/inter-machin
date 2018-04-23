<?php

namespace Tests\AppBundle\Fake;

use AppBundle\Utils\AppConfig;
use UserBundle\Entity\User;

class FakeUser implements FakeObjectsInterface
{
    private static $user;

    public static function getObject($admin = false, $alive = true, $money = 1500, $forceNew = false)
    {
        if (null == self::$user || $forceNew) {
            $user = new User();
            $user->setUsername(self::getRandName());
            $user->setAlive($alive);
            $user->setMoney($money);
            $user->setAction(AppConfig::USER_MAX_ACTION_POINT);
            $user->setDateOfBirth(new \DateTime('-3 month'));
            $user->setEmail('fake@user.net');
            $user->setCity(FakeCity::getObject());
            $user->setEnabled(true);
            if (true === $admin) {
                $user->addRole('ROLE_ADMIN');
            }

            self::$user = $user;
        }
        return self::$user;
    }

    private static function getRandName()
    {
        return self::getNames() . self::getNames() . self::getNames();
    }

    private static function getNames()
    {
        $names = ['par', 'tac', 'chi', 'muc', 'dal', 'tri', 'trou', 'dra', 'mos', 'pic', 'puc', 'faj', 'feul', 'pon', 'tou', 'ne', 'de', 'da', 'du', 'min', 'pin', 'tin', 'tez'];
        return $names[array_rand($names)];
    }
}