<?php

namespace AppBundle\Services\Game;

use UserBundle\Entity\User;

interface GameInterface
{
    public function execute(User $user, $amount, $data);

    public function getName();

    public function getCost();

    public function recordGameAction(User $user, $gain, $amount, $status);

    public function userCanPlay(User $user, $amount);
}