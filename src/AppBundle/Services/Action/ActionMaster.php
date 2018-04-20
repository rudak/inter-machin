<?php

namespace AppBundle\Services\Action;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

abstract class ActionMaster
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var SessionInterface
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
     * Pluralisation des point(S) si le montant > 1
     * @param $amount
     * @return string
     */
    protected function getPointsText($amount)
    {
        #TODO: foutre ca autre part
        return sprintf("%d %s", $amount, ($amount > 1 ? 'points' : 'point'));
    }
}