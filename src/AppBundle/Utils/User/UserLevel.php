<?php

namespace AppBundle\Utils\User;

use UserBundle\Entity\User;

class UserLevel
{

    const LEVEL_UP_COEF = 1000;

    public static function getLevelUpPrice(User $user)
    {
        return pow($user->getCompetences()->getLevel(),2) * self::LEVEL_UP_COEF;
    }
}