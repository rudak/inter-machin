<?php

namespace AppBundle\Services\Game;

use UserBundle\Entity\User;

interface GameInterface
{
    const BIM = 123;

    public function execute(User $user, $amount);

    public function getName();

    public function getCost();

    public function recordGameAction(User $user, $gain, $status);

    public function userCanPlay(User $user, $amount);


}