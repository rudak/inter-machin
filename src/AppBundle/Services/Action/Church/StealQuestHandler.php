<?php

namespace AppBundle\Services\Action\Church;

use AppBundle\Entity\Action\Church;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

class StealQuestHandler
{
    const STEAL_PA      = 2;
    const PERCENT_STEAL = 50; // Chance de réussite du vole

    protected $em;

    protected $session;

    protected $churchAction;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em      = $em;
        $this->session = $session;
    }

    public function execute(User $user)
    {
        $this->churchAction = new Church($user);
        $this->churchAction->setType(Church::TYPE_STEAL);
        if ($this->canSteal($user)) {
            $this->stealAction($user);
        }
        $this->em->persist($this->churchAction);
        $this->em->flush();
        return;
    }

    private function canSteal(User $user)
    {
        if ($user->getAction() < self::STEAL_PA) {
            $this->session->getFlashBag()->add('warning', sprintf("Impossible de voler, vous n'avez pas assez de PA !"));
            return false;
        }

        return true;
    }

    private function stealAction(User $user)
    {
        $user->removeActionPoint(self::STEAL_PA);
        if (mt_rand(1, 100) > self::PERCENT_STEAL) {
            $this->session->getFlashBag()->add('warning', sprintf("Vous vous êtes fait prendre la main dans le sac !"));
            return false;
        }
        $monneySteal = mt_rand(1, 200);
        $user->addMoney($monneySteal);
        $this->session->getFlashBag()->add('success', sprintf("Vous avez réussis à volé %d$", $monneySteal));
        $this->churchAction->setStatus(Church::STATUS_SUCCESSFULL);
        $this->churchAction->setLoot($monneySteal);
        return true;
    }

}