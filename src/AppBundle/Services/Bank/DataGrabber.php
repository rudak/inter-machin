<?php

namespace AppBundle\Services\Bank;

use AppBundle\Entity\Action\Purchase;
use AppBundle\Entity\Bank\Account;
use AppBundle\Entity\Weapon;
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
                'level' => $account->getLevel(),
            ];
        }
        return $out;
    }

    public function getAccountsData()
    {
        $accounts = $this->em->getRepository(Account::class)->findAll();
        $out      = [];
        foreach ($accounts as $account) {
            $username         = $account->getUser()->getUsername();
            $out[$username][] = [
                'date'     => (int)$account->getDate()->format('U'),
                'money'    => $account->getAmount(),
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

    public function getpurchaseData()
    {
        $purchases = $this->em->getRepository(Purchase::class)->getCountPurchasesByWeapon();
        $out       = [];
        /** @var Purchase $purchase */
        foreach ($purchases as $purchase) {
            $out[] = [
                $this->em->getRepository(Weapon::class)->find($purchase['id'])->getName(),
                (int)$purchase['nb_achat'],
            ];
        }
        return $out;
    }
}