<?php

namespace AppBundle\Services\Bank;

use AppBundle\Entity\Bank\Account;
use Doctrine\ORM\EntityManagerInterface;
use UserBundle\Entity\User;

class DataGrabber
{
    protected $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getAccountData(User $user)
    {
        $accounts = $this->em->getRepository(Account::class)->getAccountsForUser($user);
        $out      = [];
        foreach ($accounts as $account) {
            $out[] = [
                (int)$account->getDate()->format('U'),
                $account->getAmount(),
            ];
        }
        return $out;
    }
}