<?php

namespace AppBundle\Services\Command;

use Doctrine\ORM\EntityManagerInterface;

class CronEmCommand
{
    protected $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}