<?php

Namespace AppBundle\Services\Action\Church;

use AppBundle\Entity\Action\Church;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

class PrayHandler
{
    const PRAY_PRICE   = 100;
    const PERCENT_PRAY = 30; // Chance de réussite de la prière

    protected $em;

    protected $session;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em      = $em;
        $this->session = $session;
    }

    public function execute(User $user)
    {
        $this->churchAction = new Church($user);
        $this->churchAction->setType(Church::TYPE_PRAY);
        if ($this->canPray($user)) {
            $this->prayAction($user);
        }
        $this->em->persist($this->churchAction);
        $this->em->flush();
        return;
    }

    private function canPray(User $user)
    {
        if ($user->getMoney() < self::PRAY_PRICE) {
            $this->session->getFlashBag()->add('warning', sprintf("Impossible de prier, vous n'avez pas assez d'argent !"));
            return false;
        }

        return true;
    }

    private function prayAction(User $user)
    {
        $user->removeMoney(self::PRAY_PRICE);
        if (mt_rand(1, 100) > self::PERCENT_PRAY) {
            $this->session->getFlashBag()->add('warning', sprintf("Désolé mais dieu n'a pas entendu votre appel"));
            return false;
        }
        $this->session->getFlashBag()->add('success', sprintf("Votre prière à été exaucé vous avez récupérer un PA"));
        $user->addActionPoint(1);
        $this->churchAction->setStatus(Church::STATUS_SUCCESSFULL);
        return true;
    }
}