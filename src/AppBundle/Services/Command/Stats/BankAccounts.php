<?php

namespace AppBundle\Services\Command\Stats;

use AppBundle\Entity\Bank\Account;
use UserBundle\Entity\User;

class BankAccounts extends CronEmCommand
{

    public function execute()
    {
        $users = $this->em->getRepository(User::class)->findAll();
        foreach ($users as $user) {
            $this->em->persist((new Account())->hydratAccount($user));
        }
        $this->em->flush();
    }
}