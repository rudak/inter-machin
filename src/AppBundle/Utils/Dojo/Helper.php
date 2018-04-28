<?php
/**
 * Created by PhpStorm.
 * User: rparisot
 * Date: 27/04/2018
 * Time: 17:01
 */

namespace AppBundle\Utils\Dojo;

use AppBundle\Utils\AppConfig;
use UserBundle\Entity\User;

class Helper
{
    public static function getAttackPrice(User $user)
    {
        return $user->getCompetences()->getAttack() * AppConfig::COEF_BUY_COMPETENCES;
    }

    public static function getDefensePrice(User $user)
    {
        return $user->getCompetences()->getDefense() * AppConfig::COEF_BUY_COMPETENCES;
    }

    public static function getSkillPrice(User $user)
    {
        return $user->getCompetences()->getSkill() * AppConfig::COEF_BUY_COMPETENCES;
    }

}