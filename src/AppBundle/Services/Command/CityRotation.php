<?php

namespace AppBundle\Services\Command;

use AppBundle\Entity\Action\CityMove;
use AppBundle\Entity\City;
use UserBundle\Entity\User;

class CityRotation extends CronEmCommand
{
    public function execute()
    {
        $users  = $this->em->getRepository(User::class)->findAll();
        $cities = $this->em->getRepository(City::class)->findAll();
        foreach ($users as $user) {
            $this->randomlyMoveUser($user, $cities);
        }
        $this->em->flush();
    }

    private function randomlyMoveUser(User $user, array $cities)
    {
        $newCity = $cities[array_rand($cities)];
        if ($user->getCity() == $newCity) {
            return;
        }
        $user->setCity($newCity);
        $this->em->persist($user);
        $this->em->persist(new CityMove($user));
    }
}