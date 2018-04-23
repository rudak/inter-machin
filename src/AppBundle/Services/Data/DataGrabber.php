<?php

namespace AppBundle\Services\Data;

use AppBundle\Entity\Action\Game;
use AppBundle\Entity\Action\Purchase;
use AppBundle\Entity\Bank\Account;
use AppBundle\Entity\Weapon;
use AppBundle\Services\Game\Dice;
use AppBundle\Services\Game\OneTen;
use AppBundle\Utils\User\UserLevel;
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
        $from     = new \DateTime('-2 week');
        $accounts = $this->em->getRepository(Account::class)->getAccountsForAdminGraph($from);
        $out      = [];
        foreach ($accounts as $account) {
            /** @var $account Account */
            $username         = $account->getUser()->getUsername();
            $out[$username][] = [
                'date'  => (int)$account->getDate()->format('U'),
                'money' => $account->getAmount(),
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

    /**
     * Renvoie le tableau des niveaux de chaque joueurs
     * @return array
     */
    public function getLevelsData()
    {
        $from     = new \DateTime('-2 week');
        $accounts = $this->em->getRepository(Account::class)->getAccountsForAdminGraph($from);
        $out      = [];
        foreach ($accounts as $account) {
            /** @var $account Account */
            $out[$account->getUser()->getUsername()][] = [
                'date'  => (int)$account->getDate()->format('U'),
                'level' => $account->getLevel(),
            ];
        }
        return $out;
    }


    public function getGameOneTenData()
    {
        return $this->em->getRepository(Game::class)->getGameInfos(OneTen::GAME_NAME);
    }

    public function getGameDicesData()
    {
        return $this->em->getRepository(Game::class)->getGameInfos(Dice::GAME_NAME);
    }
}