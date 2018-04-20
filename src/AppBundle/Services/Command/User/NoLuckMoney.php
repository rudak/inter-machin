<?php

namespace AppBundle\Services\Command\User;

use AppBundle\Services\Command\CronCommandInterface;
use AppBundle\Services\Command\CronEmCommand;
use AppBundle\Utils\User\UserLevel;
use UserBundle\Entity\User;
use AppBundle\Utils\AppConfig;

class NoLuckMoney extends CronEmCommand implements CronCommandInterface
{

    public function execute()
    {
        foreach ($this->em->getRepository('UserBundle:User')->findAll() as $user) {
            if (!$user->getAlive() || rand(0, 100) > AppConfig::NO_LUCK_PERCENTAGE) {
                continue;
            }
            $this->updateUser($user);
        }
        $this->em->flush();
    }

    public function updateUser(User $user)
    {
        $amount = $this->getAmount($user);
        //            TODO: Transformer en 'action'
//        $this->em->persist(LogCreator::getLog($user, true, sprintf($this->getReason(), $user->getUsername(), $amount), LogCreator::TYPE_NO_LUCK));
        $user->removeMoney($amount);
        $this->em->persist($user);
    }

    private function getAmount(User $user)
    {
        return rand(1, 5) * UserLevel::getLvl($user);
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