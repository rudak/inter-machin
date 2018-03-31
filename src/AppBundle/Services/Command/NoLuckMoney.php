<?php

namespace AppBundle\Services\Command;

use AppBundle\Utils\Log\LogCreator;
use Doctrine\ORM\EntityManagerInterface;
use UserBundle\Entity\User;

class NoLuckMoney
{
    const RECURRENCE_PERCENTAGE = 2;

    private $em;

    /**
     * Luck constructor.
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function updateMoney()
    {
        $users = $this->em->getRepository('UserBundle:User')->findAll();

        foreach ($users as $user) {
            if ('admin' == $user->getUsername()) {
                continue;
            }
            if (rand(0, 100) > self::RECURRENCE_PERCENTAGE) {
                continue;
            }
            if (!$user->getAlive()) {
                continue;
            }
            $this->updateUserWallet($user);
        }
    }

    private function updateUserWallet(User $user)
    {
        $amount = $this->getNewAmount($user);
        $this->em->persist(LogCreator::getLog($user, true, sprintf($this->getReason(), $user->getUsername(), $amount), LogCreator::TYPE_NO_LUCK));
        $newMoney = $user->getMoney() - $amount;
        $user->setMoney($newMoney);
        $this->em->persist($user);
        $this->em->flush();
    }

    private function getNewAmount(User $user)
    {
        return rand(1, 5) * $user->getCompetences()->getLevel();
    }


    private function getReason()
    {
        $reasons = [
            'Un huissier de justice a pris [money] à [user].',
            'Un enfant roumain a volé [money] à [user].',
            'Un clochard menaçant a pris [money] à [user].',
            '[user] a perdu [money] dans la rue.',
            '[user] a perdu [money] dans les toilettes.',
            '[user] a perdu [money] dans la foret.',
            '[user] a perdu [money] dans le bus.',
        ];
        return str_replace(['[user]', '[money]'], ['%1$s', '%2$d$'], $reasons[array_rand($reasons)]);
    }
}