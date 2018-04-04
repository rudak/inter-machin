<?php

namespace AppBundle\Services\Command;

use AppBundle\Utils\Log\LogCreator;
use Doctrine\ORM\EntityManagerInterface;
use UserBundle\Entity\User;

class NoLuckMoney extends CronEmCommand implements CronCommandInterface
{
    const RECURRENCE_PERCENTAGE = 2;

    public function execute()
    {
        foreach ($this->em->getRepository('UserBundle:User')->findAll() as $user) {
            if (
                'admin' == $user->getUsername() ||
                !$user->getAlive() ||
                rand(0, 100) > self::RECURRENCE_PERCENTAGE
            ) {
                continue;
            }
            $this->updateUser($user);
        }
        $this->em->flush();
    }

    public function updateUser(User $user)
    {
        $amount = $this->getAmount($user);
        if ($amount > $user->getMoney()) {
            $amount = $user->getMoney();
        }
        $this->em->persist(LogCreator::getLog($user, true, sprintf($this->getReason(), $user->getUsername(), $amount), LogCreator::TYPE_NO_LUCK));
        $user->removeMoney($amount);
        $this->em->persist($user);
    }

    private function getAmount(User $user)
    {
        return rand(1, 5) * $user->getCompetences()->getLevel();
    }


    private function getReason()
    {
        $reasons = [
            'Un huissier de justice a pris [money]$ à [user].',
            'Un enfant roumain a volé [money]$ à [user].',
            'Un clochard menaçant a pris [money]$ à [user].',
            '[user] a perdu [money]$ dans la rue.',
            '[user] a perdu [money]$ dans les toilettes.',
            '[user] a perdu [money]$ dans la foret.',
            '[user] a perdu [money]$ dans le bus.',
        ];
        return str_replace(['[user]', '[money]'], ['%1$s', '%2$d'], $reasons[array_rand($reasons)]);
    }
}