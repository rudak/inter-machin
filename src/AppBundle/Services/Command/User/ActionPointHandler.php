<?php

namespace AppBundle\Services\Command\User;

use UserBundle\Entity\User;

class ActionPointHandler extends CronEmCommand
{
    public function addPoints()
    {
        $users = $this->em->getRepository(User::class)->findAll();
        foreach ($users as $user){
            $user->addActionPoint(1);
            $this->em->persist($user);
        }
        $this->em->flush();
    }
}