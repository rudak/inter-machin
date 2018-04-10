<?php

namespace AppBundle\Services\Action;

use AppBundle\Entity\Action\Steal;
use AppBundle\Utils\Log\LogCreator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

class StealHandler
{
    protected $em;

    /**
     * @var SessionInterface
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

    public function execute(User $victim, User $burglar)
    {
        if (!$this->burglarCanSteal($victim, $burglar)) {
            return false;
        }
        $this->stealHim($victim, $burglar);
        return;
    }

    private function burglarCanSteal(User $victim, User $burglar)
    {
        if (!$victim->getAlive()) {
            $this->session->getFlashBag()->add('warning', sprintf("Impossible de voler %s, il est mort!", $victim->getUsername()));
            return false;
        }
        if (!$victim->getMoney()) {
            $this->session->getFlashBag()->add('warning', sprintf("Impossible de voler %s, il est fauché!", $victim->getUsername()));
            return false;
        }
        return true;
    }

    private function stealHim(User $victim, User $burglar)
    {
        $max = $this->maxCanSteal($victim);
    }

    private function maxCanSteal(User $victim)
    {

    }


}