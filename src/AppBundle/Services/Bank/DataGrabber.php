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
            /** @var $account Account */
            $out[] = [
                'date'  => (int)$account->getDate()->format('U'),
                'money' => $account->getAmount(),
                'loan'  => $account->getLoan(),
            ];
        }
        return $out;
    }

    public function getUsersMoneyData()
    {
        $users = $this->em->getRepository(User::class)->getAllUsersForAdmin();
        $out   = [];
        /** @var User $user */
        foreach ($users as $user) {
            $out[] = [
                'name'  => $user->getUsername(),
                'money' => $user->getMoney(),
            ];
        }
        return $out;
    }
}