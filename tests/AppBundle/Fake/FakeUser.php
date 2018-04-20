<?php

namespace Tests\AppBundle\Fake;

use AppBundle\Utils\AppConfig;
use UserBundle\Entity\User;

class FakeUser
{
    private static $user;

    public static function getObject($admin = false, $alive = true, $money = 1500)
    {
        if (null == self::$user) {
            $user = new User();
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
}