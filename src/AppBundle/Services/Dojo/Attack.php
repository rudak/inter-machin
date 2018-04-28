<?php

namespace AppBundle\Services\Dojo;

use UserBundle\Entity\User;

class Attack extends CompetencesMaster
{
    public function execute(User $user)
    {
        $price = $this->getCompetencePrice($user->getCompetences()->getAttack());
        if ($user->getMoney() < $price) {
            return;
        }
        $user->removeMoney($price);
        $user->getCompetences()->addAttackPoints(1);
        $this->persistUser($user);
    }
}