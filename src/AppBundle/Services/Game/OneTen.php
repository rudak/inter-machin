<?php

namespace AppBundle\Services\Game;

use UserBundle\Entity\User;

class OneTen extends GameMaster
{
    const GAME_NAME = 'OneTen';
    const PA_COST   = 1;

    public function execute(User $user, $amount)
    {
        if (!$this->userCanPlay($user, $amount)) {
            return false;
        }
        $user->removeMoney($amount);
        $user->removeActionPoint($this->getCost());
        if (mt_rand(0, 1000) > 100) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous avez joué %d$ à %s mais vous avez perdu ! Merci.", $amount, $this->getName()));
            $this->em->persist($user);
            $this->recordGameAction($user, false, $amount, false);
            return false;
        }

        $gain = $amount * 10;
        $this->session->getFlashBag()->add('success', sprintf("Vous avez joué %d$ à %s et vous avez gagné %d$ !", $amount, $this->getName(), $gain));
        $user->addMoney($gain);
        $this->recordGameAction($user, $gain, $amount, true);
        $this->em->persist($user);
    }

    public function getCost()
    {
        return self::PA_COST;
    }

    public function getName()
    {
        return self::GAME_NAME;
    }
}