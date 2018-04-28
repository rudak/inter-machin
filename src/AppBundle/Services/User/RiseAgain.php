<?php

namespace AppBundle\Services\User;

use AppBundle\Entity\Action\Alive;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

class RiseAgain
{

    private $session;

    private $em;

    /**
     * RiseAgain constructor.
     * @param $session
     * @param $em
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->em      = $em;
    }


    public function execute(User $user)
    {
        $user->setAlive(true);
        $user->addMoney($user->getSaving());
        $user->setSaving(null);
        $user->getCompetences()->setLife(100);
        $user->getCompetences()->setLevel(1);
        $user->getCompetences()->setAttack(0);
        $user->getCompetences()->setDefense(0);
        $user->getCompetences()->setSkill(0);
        
        $this->em->persist($user);
        $alive = new Alive($user);
        $this->em->persist($alive);
        $this->em->flush();

        $this->session->getFlashBag()->add('success', sprintf('Vous êtes à nouveau en vie ! Avec une cagnotte de %d$ ! Bon courage...', $user->getMoney()));
    }
}