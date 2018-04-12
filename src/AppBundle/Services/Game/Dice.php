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
    const NB_DICES  = 5;

    private $dices;

    private $dicesRegrouped;

    public function execute(User $user, $amount, $data = null)
    {
        if (!$this->userCanPlay($user, $amount)) {
            return false;
        }
        $user->removeMoney($amount);
        $user->removeActionPoint($this->getCost());

        $this->dicesRegrouped = array_count_values($this->launchDices());

        if (!$valeurGagnante = $this->getPair()) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous avez parié %d$ à %s, mais vous avez perdu. Try again", $amount, $this->getName()));
            $this->em->persist($user);
            $this->recordGameAction($user, false, $amount, false);
            return false;
        }

        $gain = $amount * $valeurGagnante;
        $this->session->getFlashBag()->add('success', sprintf("Vous avez parié %d$, vous avez fait une paire de %d , vous avez donc gagné %d$", $amount, $valeurGagnante, $gain));
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

    /**
     * Return la valeur de la paire si non false
     * @return false|int|string
     */
    private function getPair()
    {
        return array_search(2, $this->dicesRegrouped);
    }

    /**
     * Lances les dés
     */
    private function launchDices()
    {
        $dices = [];
        for ($i = 0; $i < self::NB_DICES; $i++) {
            $dices[] = mt_rand(1, 6);
        }
        return $dices;
    }
}