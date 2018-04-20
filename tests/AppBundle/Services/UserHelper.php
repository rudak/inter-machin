<?php

namespace Tests\AppBundle\Services;

use AppBundle\Utils\AppConfig;
use Tests\AppBundle\CityHelper;
use UserBundle\Entity\User;

class UserHelper
{
    private static $user;

    public static function getFakeUser($admin = false, $alive = true, $money = 1500)
    {
        if (null == self::$user) {
            $user = new User();
            $user->setAlive($alive);
            $user->setMoney($money);
            $user->setAction(AppConfig::USER_MAX_ACTION_POINT);
            $user->setDateOfBirth(new \DateTime('-3 month'));
            $user->setEmail('fake@user.net');
            $user->setCity(CityHelper::getFakeCity());
            $user->setEnabled(true);
            if (true === $admin) {
                $user->addRole('ROLE_ADMIN');
            }

            self::$user = $user;
        }
        return self::$user;
    }
}