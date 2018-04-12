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
    const GAME_NAME               = 'Dice';
    const PA_COST                 = 8;
    const NB_DICES                = 5;

    const GAIN_COEF_FOR_PAIR      = 2;
    const GAIN_COEF_FOR_TWO_PAIRS = 3;
    const GAIN_COEF_FOR_BRELAN    = 4;
    const GAIN_COEF_FOR_SQUARE    = 6;
    const GAIN_COEF_FOR_QUINT     = 8;
    const GAIN_COEF_FOR_FULL      = 11;
    const GAIN_COEF_FOR_SUIT      = 15;

    private $pair = [];

    private $brelan;

    private $square;

    private $quint;

    public function execute(User $user, $amount, $data = null)
    {
        if (!$this->userCanPlay($user, $amount)) {
            return false;
        }
        $user->removeMoney($amount);
        $user->removeActionPoint($this->getCost());

        if (mt_rand(0, 10) == 3) {
            $this->session->getFlashBag()->add('warning', $this->getLooseReason());
            $this->recordGameAction($user, null, $amount, false);
            return;
        }

        $diceResults = array_count_values($this->launcheDices());

        if (5 == count($diceResults)) {
            $this->suitResult($user, $amount);
            $this->em->persist($user);
            return;
        }

        foreach ($diceResults as $faceNumber => $nb) {
            if (1 == $nb) continue;
            $this->dispatchResults($nb, $faceNumber);
        }

        if ($this->isItLoose()) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous avez joué %d$ à %s est vous avez perdu ! LOL", $amount, $this->getName()));
            $this->recordGameAction($user, null, $amount, false);
            return;
        }
        $this->win($user, $amount);
    }

    private function isItLoose()
    {
        return empty($this->pair) && !$this->brelan && !$this->square && !$this->quint;
    }

    private function win(User $user, $amount)
    {

        if ($this->brelan && count($this->pair)) {
            $this->fullresult($user, $amount);
        }

        if ($this->quint) {
            $this->quintResult($user, $amount);
        }

        if ($this->square) {
            $this->squareResult($user, $amount);
        }
        if ($this->brelan) {
            $this->brelanResult($user, $amount);
        }
        if (!empty($this->pair)) {
            $this->pairResult($user, $amount);
        }
    }

    private function suitResult(User $user, $amount)
    {
        $gain = $amount * self::GAIN_COEF_FOR_SUIT;
        $user->addMoney($gain);
        $this->recordGameAction($user, $gain, $amount, true);
        $this->session->getFlashBag()->add('success', "Mais putain! Vous faites une Suite !!" . $this->getGainMessage($gain));
    }

    private function fullresult(User $user, $amount)
    {
        $gain = $amount * self::GAIN_COEF_FOR_FULL;
        $user->addMoney($gain);
        $this->recordGameAction($user, $gain, $amount, true);
        $this->session->getFlashBag()->add('success', sprintf("Amazing ! Vous faites un putain de FULL au %d par les %d !%s", $this->brelan, array_shift($this->pair), $this->getGainMessage($gain)));
        $this->brelan = null;
    }

    private function quintResult(User $user, $amount)
    {
        $gain = $amount * self::GAIN_COEF_FOR_QUINT;
        $user->addMoney($gain);
        $this->recordGameAction($user, $gain, $amount, true);
        $this->session->getFlashBag()->add('success', sprintf("Ouuahhh ! Vous faites une quinte de %d !%s", $this->quint, $this->getGainMessage($gain)));
    }

    private function squareResult(User $user, $amount)
    {
        $gain = $amount * self::GAIN_COEF_FOR_SQUARE;
        $user->addMoney($gain);
        $this->recordGameAction($user, $gain, $amount, true);
        $this->session->getFlashBag()->add('success', sprintf("Yooo mannn ! Vous faites un carré de %d !%s", $this->square, $this->getGainMessage($gain)));
    }

    private function brelanResult(User $user, $amount)
    {
        $gain = $amount * self::GAIN_COEF_FOR_BRELAN;
        $user->addMoney($gain);
        $this->recordGameAction($user, $gain, $amount, true);
        $this->session->getFlashBag()->add('success', sprintf("Youpii ! Vous faites un brelan de %d !%s", $this->brelan, $this->getGainMessage($gain)));
    }

    private function pairResult(User $user, $amount)
    {
        $pairMessage = [];
        rsort($this->pair);
        foreach ($this->pair as $pair) {
            $pairMessage[] = sprintf("une paire de %d", $pair);
        }
        $gain = $amount * (count($this->pair) == 1 ? self::GAIN_COEF_FOR_PAIR : self::GAIN_COEF_FOR_TWO_PAIRS);
        $user->addMoney($gain);
        $this->recordGameAction($user, $gain, $amount, true);
        $this->session->getFlashBag()->add('success', "Gagné ! Vous faites " . implode(' et ', $pairMessage) . ' !' . $this->getGainMessage($gain));
    }

    private function getGainMessage($gain)
    {
        return sprintf(" Vous gagnez %d$ !", $gain);
    }

    private function getLooseReason()
    {
        $reasons = [
            'Tu as balancé les dés par terre, tu perds.',
            'Un dé a sauté sous la table, perdu.',
            'Un dé a affiché 7, il doit y avoir une erreur, dans le doute, perdu.',
            'Un dé est en équilibre sur un bord, pas de bol, perdu.',
            'Le banquier regardait la télé, c\'est perdu. Try again ?',
        ];
        return $reasons[array_rand($reasons)];
    }

    private function dispatchResults($nb, $faceNumber)
    {
        switch ($nb) {
            case 2:
                $this->pair[] = $faceNumber;
                break;
            case 3:
                $this->brelan = $faceNumber;
                break;
            case 4:
                $this->square = $faceNumber;
                break;
            case 5:
                $this->quint = $faceNumber;
                break;
        }
    }

    private function launcheDices()
    {
        $dices = [];
        for ($i = 0; $i < self::NB_DICES; $i++) {
            $dices[] = mt_rand(1, 6);
        }
        return $dices;
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