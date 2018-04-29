<?php

namespace AppBundle\Services\Dojo;

use AppBundle\Utils\AppConfig;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserBundle\Entity\User;

abstract class CompetencesMaster
{
    const ATTACK = 'attack';
    const DEFENSE = 'defense';
    const SKILL = 'skill';

    protected $em;

    protected $session;

    public function __construct(EntityManagerInterface $em, SessionInterface $session)
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