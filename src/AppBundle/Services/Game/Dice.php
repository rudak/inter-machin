<?php
/**
 * Created by PhpStorm.
 * User: rparisot
 * Date: 11/04/2018
 * Time: 12:24
 */

namespace AppBundle\Services\Game;

use UserBundle\Entity\User;

class Dice extends GameMaster
{

    public function execute(User $user, $amount, $data = null)
    {
        if (!$this->userCanPlay($user, $amount)) {
            return false;
        }
        $user->removeMoney($amount);
        $user->removeActionPoint($this->getCost());
        $this->recordGameAction($user, 10, true);
    }

    public function getName()
    {
        return 'Dice';
    }

    public function getCost()
    {
        return 1;
    }
}