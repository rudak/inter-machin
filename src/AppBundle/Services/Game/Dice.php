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
    const GAME_NAME         = 'Dice';
    const PA_COST           = 1;
    const NB_DICES          = 5;
    const INDEX_FACE_NUMBER = 'faceNumber';
    const INDEX_NB          = 'nb';

    private $pair = [];

    private $brelan;

    private $square;

    private $quint;

    private $full = false;

    public function execute(User $user, $amount, $data = null)
    {
        if (!$this->userCanPlay($user, $amount)) {
            return false;
        }
        $user->removeMoney($amount);
        $user->removeActionPoint($this->getCost());

        $dices = array_count_values($this->launcheDices());

        $results = [];
        foreach ($dices as $faceNumber => $nb) {
            if (1 == $nb) {
                continue;
            }
            $results[] = $this->hydratResults($faceNumber, $nb);
        }

        if (!count($results)) {
            echo "perdu !";
            die;
        }

        foreach ($results as $result) {
            $this->dispatchResults($result[self::INDEX_NB], $result[self::INDEX_FACE_NUMBER]);
        }

        if ($this->brelan && count($this->pair)) {
            $this->full = true;
        }

        if ($this->full) {
            $this->fullresult();
        }

        if ($this->quint) {
            $this->quintResult();
        }

        if ($this->square) {
            $this->squareResult();
        }
        if ($this->brelan) {
            $this->brelanResult();
        }

        if (is_array($this->pair) && !empty($this->pair)) {
            $this->pairResult();
        }
        die;
    }

    private function fullresult()
    {
        echo sprintf("Amazing ! Vous faites un putain de FULL au %d par les %d !", $this->brelan, $this->pair[0]);
        $this->brelan = null;
        $this->pair   = null;
    }

    private function quintResult()
    {
        echo sprintf("Ouuahhh ! Vous faites une quinte de %d !", $this->quint);
    }

    private function squareResult()
    {
        echo sprintf("Yooo mannn ! Vous faites un carré de %d !", $this->square);
    }

    private function brelanResult()
    {
        echo sprintf("Youpii mannn ! Vous faites un brelan de %d !", $this->brelan);
    }

    private function pairResult()
    {
        $pairMessage = [];

        foreach ($this->pair as $pair) {
            $pairMessage[] = sprintf("une paire de %d", $pair);
        }
        echo "Gagné ! Vous faites " . implode(' et ', $pairMessage) . ' !';
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
            $dices[] = mt_rand(1, 4);
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

    private function hydratResults($faceNumber, $nb)
    {
        return [
            self::INDEX_FACE_NUMBER => $faceNumber,
            self::INDEX_NB          => $nb,
        ];
    }
}