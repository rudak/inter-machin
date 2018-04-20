<?php

namespace AppBundle\Utils\User;

use UserBundle\Entity\User;

class UserLevel
{

    const LEVEL_UP_COEF = 1000;

    public static function getLevelUpPrice(User $user)
    {
        return pow(self::getLvl($user), 2) * self::LEVEL_UP_COEF;
    }

    public static function getLvl(User $user)
    {
        return $user->getCompetences()->getLevel();
    }

}