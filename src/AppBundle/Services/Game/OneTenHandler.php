<?php

namespace AppBundle\Services\Game;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

class OneTenHandler
{
    const PA = 1;

    protected $em;

    /**
     * @var Session
     */
    private $session;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em      = $em;
        $this->session = $session;
    }

    public function execute(User $user, $amount)
    {
        if ($user->getMoney() < $amount) {
            $this->session->getFlashBag()->add('warning', "Vous n'avez pas assez d'argent pour jouer à OneTen !");
            return false;
        }
        if ($user->getAction() < self::PA) {
            $this->session->getFlashBag()->add('warning', "Vous n'avez pas assez de PA pour jouer à OneTen !");
            return false;
        }
        $user->removeMoney($amount);
        $user->removeActionPoint(self::PA);
        if (mt_rand(0, 1000) > 100) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous avez joué %d$ à OneTen mais vous avez perdu ! Merci.", $amount));
            $this->em->persist($user);
            return false;
        }

        $gain = $amount * 10;
        $this->session->getFlashBag()->add('success', sprintf("Vous avez joué %d$ à OneTen et vous avez gagné %d$ !", $amount, $gain));
        $user->addMoney($gain);
        $this->em->persist($user);
    }
}