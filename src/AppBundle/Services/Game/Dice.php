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
    const GAME_NAME = 'Dice';
    const PA_COST   = 1;
    const NB_DICE   = 2;

    private $dices;

    public function execute(User $user, $amount, $data = null)
    {
        if (!$this->userCanPlay($user, $amount)) {
            return false;
        }
//        $user->removeMoney($amount);
//        $user->removeActionPoint($this->getCost());
//        $this->recordGameAction($user, 10, true);

        $this->launchDices();

        if (!$this->isPaire($this->dices)) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous avez parier %d $ à %s, mais vous avez perdu. Try again", $amount, $this->getName()));
            $this->em->persist($user);
            $this->recordGameAction($user, false, $amount, false);
            return false;
        }
        $gain = $amount * $this->dices[0];
        $this->session->getFlashBag()->add('success', sprintf("Vous avez parier %d $, vous avez fait une paire de %d, vous avez donc gagner %d $", $amount, $this->dices[0], $gain));
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

    private function isPaire($dices)
    {
        // Return la valeur de la paire si non false
        if ($dices[0] == $dices[1]) {
            return true;
        }
        return false;
    }

    private function launchDices()
    {
        // Lances les dés
        for ($i = 1; $i <= self::NB_DICE; $i++) {
            $this->dices[] = $this->getDiceValue();
        }
    }

    private function getDiceValue()
    {
        //Créer la valeur d'un dé
        return mt_rand(1, 6);
    }
}