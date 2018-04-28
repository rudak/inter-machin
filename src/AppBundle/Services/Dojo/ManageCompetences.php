<?php
/**
 * Created by PhpStorm.
 * User: rparisot
 * Date: 27/04/2018
 * Time: 17:01
 */

namespace AppBundle\Services\Dojo;

use AppBundle\Utils\Dojo\Helper;
use UserBundle\Entity\User;

class ManageCompetences
{
    public static function addAttackToUser(User $user)
    {
        $user->removeMoney(Helper::getAttackPrice($user));
        $user->getCompetences()->addAttackPoints(1);
    }
    public static function addDefenseToUser(User $user)
    {
        $user->removeMoney(Helper::getDefensePrice($user));
        $user->getCompetences()->addDefensePoints(1);
    }
    public static function addSkillToUser(User $user)
    {
        $user->removeMoney(Helper::getSkillPrice($user));
        $user->getCompetences()->addSkillPoints(1);
    }
}