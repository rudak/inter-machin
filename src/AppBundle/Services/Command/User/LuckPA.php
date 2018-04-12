<?php

namespace AppBundle\Services\Command\User;

use AppBundle\Services\Command\CronCommandInterface;
use AppBundle\Services\Command\CronEmCommand;
use UserBundle\Entity\User;
use AppBundle\Utils\AppConfig;

class LuckPA extends CronEmCommand implements CronCommandInterface
{

    public function execute()
    {
        foreach ($this->em->getRepository('UserBundle:User')->findAll() as $user) {
            if (!$user->getAlive() || mt_rand(0, 100) > AppConfig::LUCK_PA_PERCENTAGE) {
                continue;
            }
            $this->updateUser($user);
        }
        $this->em->flush();
    }


    public function updateUser(User $user)
    {
        $user->addActionPoint(1);
    }
}