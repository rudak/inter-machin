<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UtilsMaster
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

}