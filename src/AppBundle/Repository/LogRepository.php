<?php

namespace AppBundle\Repository;

use UserBundle\Entity\User;

/**
 * LogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LogRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLogs(User $user)
    {
        $qb = $this->createQueryBuilder('l')
                   ->where('(l.public = :public) OR (l.user = :user)')
                   ->setParameter('public', true)
                   ->setParameter('user', $user)
                   ->orderBy('l.id', 'DESC')
                   ->setMaxResults(20)
                   ->getQuery()
        ;
        return $qb->execute();
    }
}