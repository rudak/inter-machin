<?php

namespace AppBundle\Repository\Action;

use UserBundle\Entity\User;

/**
 * AliveRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AliveRepository extends \Doctrine\ORM\EntityRepository implements ActionRepositoryInterface
{

    public function getDeathForUser(User $user)
    {
        $qb = $this->createQueryBuilder('a')
                   ->andWhere('a.user = :user')
                   ->setParameters([
                       'user' => $user,
                   ])
                   ->orderBy('a.id', 'DESC')
                   ->getQuery()
        ;
        return $qb->execute();
    }

    /**
     * Renvoie les Alive pour les logs
     * @param User      $user
     * @param \DateTime $date
     * @return mixed
     */
    public function getByUser(User $user, \DateTime $date)
    {
        $qb = $this->createQueryBuilder('a')
                   ->where('a.user = :user')
                   ->andWhere('a.date >= :date')
                   ->setParameters([
                       'user' => $user,
                       'date' => $date,
                   ])
                   ->getQuery()
        ;
        return $qb->execute();
    }
}