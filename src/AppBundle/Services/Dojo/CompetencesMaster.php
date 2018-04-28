<?php

namespace AppBundle\Services\Dojo;

use AppBundle\Utils\AppConfig;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

class CompetencesMaster
{
    protected $em;

    protected $session;

    public function __construct(EntityManager $em, SessionInterface $session)
    {
        $this->em      = $em;
        $this->session = $session;
    }

    public function getCompetencePrice($competenceValue)
    {
        return $competenceValue * AppConfig::COEF_BUY_COMPETENCES;
    }

    public function persistUser(User $user)
    {
        $this->em->persist($user);
    }
}