<?php

namespace AppBundle\Services\Action\City;

use AppBundle\Entity\Action\CityMove;
use AppBundle\Entity\City;
use AppBundle\Services\Action\ActionMaster;
use UserBundle\Entity\User;

class CityHandler extends ActionMaster
{
    public function move(User $user, City $city)
    {
        if (!$this->userCanMove($user, $city)) {
            return false;
        }
        $this->session->getFlashBag()->add('success', sprintf("Vous etres arrivé à %s, le voyage vous a couté %d$ !", $city->getName(), $city->getPrice()));
        $user->setCity($city);
        $user->removeMoney($city->getPrice());
        $this->setCityMoveAction($user);
        $this->em->persist($user);
        return;
    }

    private function userCanMove(User $user, City $city)
    {
        if ($user->getMoney() < $city->getPrice()) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous être trop pauvre, le voyage coute %d$ !", $city->getPrice()));
            return false;
        }
        return true;
    }

    private function setCityMoveAction(User $user)
    {
        $this->em->persist(new CityMove($user, CityMove::TYPE_USER));
    }
}