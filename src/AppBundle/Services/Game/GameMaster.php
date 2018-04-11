<?php

namespace AppBundle\Services\Game;

use AppBundle\Entity\Action\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

abstract class GameMaster implements GameInterface
{
    protected $em;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em      = $em;
        $this->session = $session;
    }

    /**
     * Renvoie si le gars peut jouer ou pas
     * @param User $user
     * @param      $amount
     * @return bool
     */
    public function userCanPlay(User $user, $amount)
    {
        if ($user->getMoney() < $amount) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous n'avez pas assez d'argent pour jouer à %s !", $this->getName()));
            return false;
        }
        if ($user->getAction() < $this->getCost()) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous n'avez pas assez de PA pour jouer à %s !", $this->getName()));
            return false;
        }
        return true;
    }



    public function recordGameAction(User $user, $gain, $status)
    {
        $this->em->persist(new Game($user, $status, $this->getName(), $gain));
    }
}