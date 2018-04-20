<?php

namespace AppBundle\Services\Action\User;

use AppBundle\Services\Action\ActionMaster;
use AppBundle\Utils\User\UserLevel;
use UserBundle\Entity\User;

class LevelUp extends ActionMaster
{
    public function execute(User $user)
    {
        if (!$this->userCanLevelUp($user)) {
            return false;
        }
        $this->levelUp($user);
    }

    private function userCanLevelUp(User $user)
    {
        $levelUpPrice = UserLevel::getLevelUpPrice($user);
        if ($user->getMoney() < $levelUpPrice) {
            $this->session->getFlashBag()->add('warning', sprintf("Il vous faut %d$ pour monter de niveau ! (Il vous manque %d$).", $levelUpPrice, $levelUpPrice - $user->getMoney()));
            return false;
        }
        return true;
    }

    private function levelUp(User $user)
    {
        $levelUpPrice = UserLevel::getLevelUpPrice($user);
        $user->removeMoney($levelUpPrice);
        $level    = UserLevel::getLvl($user);
        $newLevel = $level + 1;
        $user->getCompetences()->setLevel($newLevel);
        $this->session->getFlashBag()->add('success', sprintf("Vous montez au niveau %d pour %d$ !", $newLevel, $levelUpPrice));
        $this->em->persist($user);
        $this->em->flush();
    }
}