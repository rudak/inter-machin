<?php

namespace AppBundle\Services\Command;

use UserBundle\Entity\User;

class ActionPointHandler extends CronEmCommand
{
    public function addPoints()
    {
        $users = $this->em->getRepository(User::class)->findAll();
        foreach ($users as $user){
//            $user->add
        }
    }
}