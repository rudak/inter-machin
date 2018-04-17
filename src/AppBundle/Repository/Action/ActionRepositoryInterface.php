<?php

namespace AppBundle\Repository\Action;

use UserBundle\Entity\User;

interface ActionRepositoryInterface
{
    public function getByUser(User $user, \DateTime $date);
}